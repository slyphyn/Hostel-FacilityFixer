<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StaffComplaintController extends Controller
{
    public function find(Request $request)
    {
        $query = Complaint::query();
    
        // Add conditions based on search parameters if they exist
        if ($request->filled('name_or_block_number')) {
            $query->where(function ($userQuery) use ($request) {
                $userQuery->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->input('name_or_block_number') . '%');
                })
                ->orWhere('block_number', 'like', '%' . $request->input('name_or_block_number') . '%');
            });
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
    
        $complaints = $query->paginate(10);
    
        return view('staff.all', compact('complaints'));
    }
    

    public function all()
    {
        $complaints = Complaint::paginate(10)->withQueryString(); // Ensure query strings are included in pagination links
        return view('staff.all', compact('complaints'));
    }

}
