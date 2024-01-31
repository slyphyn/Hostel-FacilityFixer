<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'block_number',
        'location_type',
        'room_number',
        'toilet_location',
        'category',
        'damage_description',
        'damage_description_other',
        'photo_path',
        'status',
        'consent',
        'assigned_staff_name',
        'assigned_staff_contact',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }

    public function statusClass()
    {
        switch ($this->status) {
            case 'pending':
                return 'warning';
            case 'in-progress':
                return 'primary';
            case 'resolved':
                return 'success';
            default:
                return 'secondary';
        }
    }

}
