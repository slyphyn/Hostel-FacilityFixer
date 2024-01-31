<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Complaint;

class ComplaintPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Complaint $complaint)
    {
        return $user->id === $complaint->user_id;
    }

    public function update(User $user, Complaint $complaint)
    {
        return $user->id === $complaint->user_id;
    }
}
