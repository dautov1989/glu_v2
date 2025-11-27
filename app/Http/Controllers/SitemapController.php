<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate XML sitemap
     */
    public function index(): Response
    {
        $posts = Post::where('is_published', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $content = view('sitemap.xml', compact('posts', 'categories'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Generate robots.txt
     */
    public function robots(): Response
    {
        $content = view('sitemap.robots')->render();

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}
