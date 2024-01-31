<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index()
    {
        Log::info('Index method reached.');
        
        // Load all complaints from the database
        $user = Auth::user();
        // $complaints = Complaint::latest()->get();
        if ($user instanceof User) {
            
            // Retrieve complaints for the user
            $complaints = $user->complaints()->latest()->paginate(10);
            
    
            return view('complaints.index', compact('complaints'));
        }

        // return view('complaints.index', compact('complaints'));
        return redirect()->route('login')->with('error', 'Authentication error');

    }

    public function create()
    {
        return view('complaints.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'block_number' => 'required',
            'location_type' => 'required|in:room,toilet',
            'room_number' => 'nullable|required_if:location_type,room',
            'toilet_location' => 'nullable|required_if:location_type,toilet',
            'category' => 'required|in:plumbing,electrical_it,general_maintenance,pest_control,safety_security',
            'damage_description' => 'required',
            'damage_description_other' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'consent' => 'required|in:allow_entry,do_not_allow_entry',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('complaint-photos', 'public');
        }

        $complaint = Complaint::create([
            'user_id' => auth()->user()->id,
            'block_number' => $request->input('block_number'),
            'location_type' => $request->input('location_type'),
            'room_number' => $request->input('room_number'),
            'toilet_location' => $request->input('toilet_location'),
            'category' => $request->input('category'),
            'damage_description' => $request->input('damage_description'),
            'damage_description_other' => $request->input('damage_description_other'),
            'photo_path' => $photoPath,
            'status' => 'pending',
            'consent' => $request->input('consent'),
        ]);
        // dd(('success'));

        $successMessage = 'Complaint submitted successfully!';
        return redirect()->route('complaints.index', ['success' => $successMessage]);
    }

    public function show(Complaint $complaint)
    {
         // Check if the method is being reached
        Log::info('Show method reached.');
        

        // Check the complaint details
        Log::info('Complaint ID: ' . $complaint->id);
        // Load the latest status from the database to ensure it's up-to-date
        $complaint->refresh();
    
        return view('complaints.show', compact('complaint'));
    }
    
    public function edit(Complaint $complaint)
    {
        return view('complaints.edit', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $this->authorize('update', $complaint);

        $request->validate([
            'block_number' => 'required',
            'location_type' => 'required|in:room,toilet',
            'room_number' => 'nullable|required_if:location_type,room',
            'toilet_location' => 'nullable|required_if:location_type,toilet',
            'category' => 'required|in:plumbing,electrical_it,general_maintenance,pest_control,safety_security',
            'damage_description' => 'required',
            'damage_description_other' => 'nullable',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($complaint->photo_path) {
                Storage::disk('public')->delete($complaint->photo_path);
            }

            $photoPath = $request->file('photo')->store('complaint-photos', 'public');
        }

        $complaint->update([
            'block_number' => $request->input('block_number'),
            'location_type' => $request->input('location_type'),
            'room_number' => $request->input('room_number'),
            'toilet_location' => $request->input('toilet_location'),
            'category' => $request->input('category'),
            'damage_description' => $request->input('damage_description'),
            'damage_description_other' => $request->input('damage_description_other'),
            'photo_path' => $request->hasFile('photo') ? $photoPath : $complaint->photo_path,
        ]);

        return redirect()->route('complaints.show', $complaint->id)->with('success', 'Complaint updated successfully!');

    }
    

    public function destroy(Complaint $complaint)
    {
        $this->authorize('delete', $complaint);
    
    // Check if the complaint has a photo path before attempting to delete
    if ($complaint->photo_path) {
        Storage::disk('public')->delete($complaint->photo_path);
    }
    
        $complaint->delete();
        $successMessage = 'Complaint deleted successfully!';

        return redirect()->route('complaints.index', ['success' => $successMessage]);
    
        // return redirect()->route('complaints.index')->with('success', 'Complaint deleted successfully!');
    }
    

    // [STAFF]
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateStatusAndStaff(Request $request, Complaint $complaint)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'assigned_staff_name' => 'nullable|string|max:255',
            'assigned_staff_contact' => 'nullable|string|max:255',
        ]);

        // Update the complaint status
        $complaint->update([
            'status' => $request->input('status'),
            'assigned_staff_name' => $request->input('assigned_staff_name'),
            'assigned_staff_contact' => $request->input('assigned_staff_contact'),
        ]);

        // Flash a success message to the session
        session()->flash('status_update_success', 'Status and assigned staff details updated successfully!');

        return redirect()->route('complaints.show', $complaint->id);
    }


}
