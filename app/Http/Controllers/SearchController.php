<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return redirect()->route('home');
        }

        $posts = Post::where('is_published', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->orderBy('published_at', 'desc')
            ->paginate(12)
            ->appends(['q' => $query]);

        return view('search.results', compact('posts', 'query'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([]);
        }

        $posts = Post::where('is_published', true)
            ->where('title', 'like', "%{$query}%")
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get(['title', 'slug', 'published_at']);

        // Manually load category to avoid N+1 if needed, or just select it. 
        // For simplicity, we'll return basic data.
        // If categories are needed, we can use with('category').

        $results = $posts->map(function ($post) {
            return [
                'title' => $post->title,
                'slug' => $post->slug,
                'url' => route('post.show', $post->slug),
                'category' => $post->category ? $post->category->name : null, // Assuming relationship exists
            ];
        });

        return response()->json($results);
    }
}
