<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function rss()
    {
        $posts = Post::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return response()
            ->view('feed.rss', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }
}
