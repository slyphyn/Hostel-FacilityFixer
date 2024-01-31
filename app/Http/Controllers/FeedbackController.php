<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function userIndex()
    {
        $feedbacks = Feedback::where('user_id', auth()->user()->id)->get();

        return view('feedback.user_index', compact('feedbacks'));
    }
    public function create(Complaint $complaint)
    {
        return view('feedback.create', compact('complaint'));
    }

    public function store(Request $request, Complaint $complaint)
    {
        $request->validate([
            'feedback' => 'required',
        ]);

        $feedback = Feedback::create([
            'user_id' => auth()->user()->id,
            'complaint_id' => $complaint->id,
            'feedback' => $request->input('feedback'),
        ]);

        // Update complaint status, e.g., 'feedback submitted'
        $complaint->update(['status' => 'feedback submitted']); 
        return redirect()->route('complaints.show', $complaint->id)->with('success', 'Feedback submitted successfully!');
    }

    // staff
    public function staffIndex()
    {
        $feedbacks = Feedback::latest()->paginate(10);
        return view('feedback.staff_index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        return view('feedback.show', compact('feedback'));
    }

    public function updateResponse(Feedback $feedback) // Updated method name
    {
        return view('feedback.update_response', compact('feedback'));
    }

    public function saveUpdatedResponse(Request $request, Feedback $feedback)
    {
        $request->validate([
            'response' => 'required',
        ]);

        $feedback->update([
            'response' => $request->input('response'),
        ]);

        return redirect()->route('feedback.staffIndex')->with('success', 'Response updated successfully!');
    }
}
