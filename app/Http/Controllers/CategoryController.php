<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with([
                'children',
                'posts' => function ($query) {
                    $query->where('is_published', true)->orderBy('published_at', 'desc');
                }
            ])
            ->firstOrFail();

        // Получаем параметр сортировки из query string
        $sortBy = request()->get('sort', 'date_desc');

        // Строим запрос для постов
        $postsQuery = $category->posts()->where('is_published', true);

        // Применяем сортировку
        switch ($sortBy) {
            case 'date_asc':
                $postsQuery->orderBy('published_at', 'asc');
                break;
            case 'date_desc':
                $postsQuery->orderBy('published_at', 'desc');
                break;
            case 'views':
                $postsQuery->orderBy('views', 'desc');
                break;
            case 'title':
                $postsQuery->orderBy('title', 'asc');
                break;
            default:
                $postsQuery->orderBy('published_at', 'desc');
        }

        $posts = $postsQuery->paginate(12)->appends(['sort' => $sortBy]);

        return view('category.show', compact('category', 'posts', 'sortBy'));
    }
}
