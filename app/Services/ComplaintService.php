<?php

namespace App\Services;

use App\Models\Complaint;

class ComplaintService
{
    // public function generateReport($days = 30)
    // {
    //     $complaints = Complaint::where('created_at', '>=', now()->subDays($days))
    //         ->orderBy('created_at')
    //         ->get();

    //     $groupedComplaints = $complaints->groupBy(function ($complaint) {
    //         return $complaint->category;
    //     });

    //     return $groupedComplaints;
    // }

    // You can add more methods as needed for your application
}
