<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Calculate stats
        $articlesCount = Post::where('is_published', true)->count();
        $usersCount = User::count();

        // Fetch latest posts for the "Last Articles" section
        $latestPosts = Post::where('is_published', true)
            ->with('category') // Eager load category to avoid N+1 problem
            ->orderBy('published_at', 'desc')
            ->limit(8)
            ->get();

        return view('home', compact('articlesCount', 'usersCount', 'latestPosts'));
    }
}
