<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
    
        switch ($role) {
            case '3':
                $news = News::orderBy('created_at', 'desc')->get();
                return view('admin.news.index', compact('news'));
            case '2':
                $news = News::orderBy('created_at', 'desc')->get();
                return view('staff.news', compact('news'));
            default:
                $news = News::orderBy('created_at', 'desc')->get();
                return view('user.news', compact('news'));
        }
    }
    

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'visibility' => 'required|in:1,2,3', // Assuming visibility values are 1, 2, 3
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the allowed file types and size

        ]);

        // Check if the user is authenticated
        if (auth()->check()) {
            // The user is authenticated
            $user = auth()->user();

            // Create a new news article
            $news = new News();
            $news->title = $validatedData['title'];
            $news->content = $validatedData['content'];
            $news->visibility = $validatedData['visibility'];

            // Set the user_id based on the authenticated user
            $news->user_id = $user->id;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('news_images', 'public');
                $news->image = $imagePath;
            }

            $news->save();

            return redirect()->route('admin.news.index')->with('success', 'News created successfully!');
        } else {
            // The user is not authenticated, handle accordingly
            return redirect()->route('login')->with('error', 'Please log in to create news.');
        }
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'visibility' => 'required|in:1,2,3',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 

        ]);

        // Find the news article
        $news = News::findOrFail($id);

        // Update news article
        $news->title = $validatedData['title'];
        $news->content = $validatedData['content'];
        $news->visibility = $validatedData['visibility'];
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('news_images', 'public');
            $news->image = $imagePath;
        }
        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully!');
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.show', compact('news'));
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully!');
    }
}
