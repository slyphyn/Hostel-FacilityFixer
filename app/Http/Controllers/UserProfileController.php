<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;


class UserProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show user profile
    public function show(User $user)
    {
        // $user = auth()->user();
        // dd(session('success'));
        $user = User::with('userDetail')->find(auth()->id()); // Eager load userDetail relationship

        return view('user.profile.show', compact('user'));    
    }

    // Show form to edit user profile
    public function edit(User $user)
    {
        $user = auth()->user();

        return view('user.profile.edit', compact('user'));
    }

    // Update user profile
    public function update(Request $request)
    {
        // dd($request->all()); // Check form data        
        $user = Auth::user();
    
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'course' => 'nullable|string|max:255',
            'matric_number' => 'nullable|string|max:255',
            'year_of_study' => 'nullable|string|max:255',
            'hostel_name' => 'nullable|string|max:255',
            'room_number' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'position' => 'nullable|string|max:255', 
        ]);
    
        // Update user profile
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);
    
        // Check if user details exist before updating
        if ($user->userDetail) {
            $user->userDetail->update([
                'course' => $request->input('course'),
                'matric_number' => $request->input('matric_number'),
                'year_of_study' => $request->input('year_of_study'),
                'hostel_name' => $request->input('hostel_name'),
                'room_number' => $request->input('room_number'),
                'emergency_contact' => $request->input('emergency_contact'),
                'gender' => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
                'position' => $request->input('position'),
            ]);
        } else {
            // Create new user details if they don't exist
            $user->userDetail()->create([
                'course' => $request->input('course'),
                'matric_number' => $request->input('matric_number'),
                'year_of_study' => $request->input('year_of_study'),
                'hostel_name' => $request->input('hostel_name'),
                'room_number' => $request->input('room_number'),
                'emergency_contact' => $request->input('emergency_contact'),
                'gender' => $request->input('gender'),
                'date_of_birth' => $request->input('date_of_birth'),
                'position' => $request->input('position'),
            ]);
        }

        $successMessage = 'Profile successfully updated!';
   
        return redirect()->route('profile.show', ['success' => $successMessage]);

    }
    
    // Show form to change user password
    public function showChangePasswordForm()
    {
        return view('user.profile.change-password');
    }

    // Change user password

    public function changePassword(Request $request, User $user)
    {
        // Validate the form data
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Verify the current password
        if (!Hash::check($request->input('current_password'), Auth::user()->password)) {
            return redirect()->route('profile.show')->withErrors(['current_password' => 'The provided current password is incorrect.']);
        }

        // Change user password
        Auth::user()->password = Hash::make($request->input('new_password'));
        Auth::user()->save();

        // dd(session('success'));

        $successMessage = 'Password changed successfully!';
   
        return redirect()->route('profile.show', ['success' => $successMessage]);
    }
    
    

}
