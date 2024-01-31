<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function news()
    {
        $news = News::whereIn('visibility', [1, 3])->get();

        return view('user.news', compact('news'));
    }

    
}
