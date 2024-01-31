<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'course',
        'matric_number',
        'year_of_study',
        'hostel_name',
        'room_number',
        'emergency_contact',
        'gender',
        'date_of_birth',
        'position',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
