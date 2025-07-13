<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        // Example: Search within posts and categories
        $posts = Post::where('post_name', 'like', "%{$query}%")
             ->orWhere('Post_Content', 'like', "%{$query}%")
             ->get();


        $categories = Catagory::where('name', 'like', "%{$query}%")->get();

        // Return a view with the search results
        return view('search.results', compact('query', 'posts', 'categories'));
    }
}
