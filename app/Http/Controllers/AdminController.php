<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Message;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Notifications\CustomNotification;
use App\Notifications\SimpleNotification;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    // Display a list of all users
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }
    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => $request->input('role')]);
    
        return redirect()->route('admin.index')->with('success', 'User role updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User deleted successfully!');
    }
    
    // public function showReport()
    // {
    //     return view('admin.report');
    // }

    // public function generateReport(Request $request)
    // {
    //     // Validate the form data
    //     $request->validate([
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after_or_equal:start_date',
    //         'category' => 'required|in:room,toilet',
    //     ]);

    //     // Retrieve form data
    //     $startDate = Carbon::parse($request->input('start_date'));
    //     $endDate = Carbon::parse($request->input('end_date'));
    //     $category = $request->input('category');

    //     // Perform queries to get complaints based on the provided criteria
    //     $complaints = Complaint::whereBetween('created_at', [$startDate, $endDate])
    //         ->where('location_type', $category)
    //         ->get();

    //     // Pass the data to the view
    //     return view('admin.report', compact('complaints', 'startDate', 'endDate', 'category'));
    // }

    public function showReport()
    {
        return view('admin.report');
    }

    public function generateReport(Request $request)
    {
        // Validate the form data
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'category' => 'required|in:room,toilet,plumbing,electrical,general_maintenance,pest_control,safety_security',
        ]);

        // Retrieve form data
        $startDate = Carbon::parse($request->input('start_date'));
        $endDate = Carbon::parse($request->input('end_date'));
        $category = $request->input('category');

        // Perform queries to get complaints based on the provided criteria
        $complaints = Complaint::whereBetween('created_at', [$startDate, $endDate])
            ->where(function ($query) use ($category) {
                $query->where('location_type', $category)
                    ->orWhere('category', $category);
            })
            ->get();

        // Pass the data to the view
        return view('staff.report', [
            'complaints' => $complaints,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'category' => $category,
        ]);    }
    

}

