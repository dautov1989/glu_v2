<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

use App\Services\BentoService;

class HomeController extends Controller
{
    public function index()
    {
        // Calculate stats
        $articlesCount = Post::where('is_published', true)->count();
        $usersCount = User::count();

        // Fetch latest posts for the "Last Articles" section
        // Берем 10 статей для идеальной сетки Bento (4 ряда по 4 колонки)
        $latestPosts = Post::where('is_published', true)
            ->with('category') // Eager load category to avoid N+1 problem
            ->orderBy('published_at', 'desc')
            ->limit(10)
            ->get();

        // Подготовка данных для Bento Grid
        $bentoData = BentoService::prepareData($latestPosts);

        return view('home', compact('articlesCount', 'usersCount', 'latestPosts', 'bentoData'));
    }
}
