<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'user_id', 'visibility', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : null;
    }
    
}
