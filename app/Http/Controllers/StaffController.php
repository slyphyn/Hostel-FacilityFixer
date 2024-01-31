<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\News;
use App\Models\Complaint;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function news()
    {
        // Retrieve news articles based on visibility 2 and 3
        $news = News::whereIn('visibility', [2, 3])->get();

        return view('staff.news', compact('news'));
    }
    public function showReport()
    {
        return view('staff.report');
    }

    // public function generateReport(Request $request)
    // {
    //     // Validate the form data
    //     $request->validate([
    //         'start_date' => 'required|date',
    //         'end_date' => 'required|date|after_or_equal:start_date',
    //         'category' => 'required|in:room,toilet,plumbing,electrical_it,general_maintenance,pest_control,safety_security',
    //     ]);
    
    //     // Retrieve form data
    //     $startDate = Carbon::parse($request->input('start_date'));
    //     $endDate = Carbon::parse($request->input('end_date'));
    //     $category = $request->input('category');
    //     $categories = ['room', 'toilet', 'plumbing', 'electrical_it', 'general_maintenance', 'pest_control', 'safety_security'];
    
    //     // Perform queries to get complaints based on the provided criteria
    //     $complaints = Complaint::whereBetween('created_at', [$startDate, $endDate])
    //         ->where(function ($query) use ($category) {
    //             $query->where('location_type', $category)
    //                 ->orWhere('category', $category);
    //         })
    //         ->get();
            
    //     // Pass the data to the view
    //     return view('staff.report', compact('complaints', 'startDate', 'endDate', 'category', 'categories'));

    // }

    public function generateReport(Request $request)
{
    // Validate the form data
    $request->validate([
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'category' => 'required|in:room,toilet,plumbing,electrical_it,general_maintenance,pest_control,safety_security',
    ]);

    // Retrieve form data
    $startDate = Carbon::parse($request->input('start_date'));
    $endDate = Carbon::parse($request->input('end_date'));
    $category = $request->input('category');
    $categories = ['room', 'toilet', 'plumbing', 'electrical_it', 'general_maintenance', 'pest_control', 'safety_security'];

    // Perform queries to get complaints based on the provided criteria
    $complaints = Complaint::whereBetween('created_at', [$startDate, $endDate])
        ->where(function ($query) use ($category) {
            $query->where('location_type', $category)
                ->orWhere('category', $category);
        })
        ->get();

    // Statistical information
    $totalComplaints = $complaints->count();
    $resolvedComplaints = $complaints->where('status', 'resolved')->count();
    $pendingComplaints = $complaints->where('status', 'pending')->count();
    $inProgressComplaints = $complaints->where('status', 'in_progress')->count();
    $feedbackSubmittedComplaints = $complaints->where('status', 'feedback_submitted')->count();
    // Add more statistical data as needed

    // Pass the data to the view
    return view('staff.report', [
        'complaints' => $complaints,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'category' => $category,
        'categories' => $categories,
        'totalComplaints' => $totalComplaints,
        'resolvedComplaints' => $resolvedComplaints,
        'pendingComplaints' => $pendingComplaints,
        'inProgressComplaints' => $inProgressComplaints,
        'feedbackSubmittedComplaints' => $feedbackSubmittedComplaints,    ]);
}


}
