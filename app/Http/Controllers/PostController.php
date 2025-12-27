<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $sortBy = request()->get('sort', 'date_desc');
        $postsQuery = Post::where('is_published', true);

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

        return view('articles.index', compact('posts', 'sortBy'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Увеличиваем счетчик просмотров
        $post->increment('views');

        // --- Логика рекомендаций ---

        // Получаем текущую историю просмотров и категорий из сессии
        $viewedPosts = session()->get('viewed_posts', []);
        $viewedCategories = session()->get('viewed_categories', []);

        // Добавляем текущую статью и категорию в историю, если их там нет
        if (!in_array($post->id, $viewedPosts)) {
            session()->push('viewed_posts', $post->id);
            $viewedPosts[] = $post->id;
        }

        // Всегда добавляем категорию
        if (!in_array($post->category_id, $viewedCategories)) {
            session()->push('viewed_categories', $post->category_id);
            $viewedCategories[] = $post->category_id;
        }

        // Формируем запрос для рекомендуемых статей
        $recommendedPosts = Post::whereIn('category_id', $viewedCategories)
            ->whereNotIn('id', $viewedPosts)
            ->where('id', '!=', $post->id)
            ->where('is_published', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Дополняем если мало
        if ($recommendedPosts->count() < 4) {
            $needed = 4 - $recommendedPosts->count();
            $excludeIds = $recommendedPosts->pluck('id')->merge([$post->id])->toArray();

            $additionalPosts = Post::where('category_id', $post->category_id)
                ->whereNotIn('id', $excludeIds)
                ->where('is_published', true)
                ->inRandomOrder()
                ->limit($needed)
                ->get();

            $recommendedPosts = $recommendedPosts->merge($additionalPosts);
        }

        // Еще раз дополняем популярными, если все еще мало
        if ($recommendedPosts->count() < 4) {
            $needed = 4 - $recommendedPosts->count();
            $excludeIds = $recommendedPosts->pluck('id')->merge([$post->id])->toArray();

            $popularPosts = Post::whereNotIn('id', $excludeIds)
                ->where('is_published', true)
                ->orderBy('views', 'desc')
                ->limit($needed)
                ->get();

            $recommendedPosts = $recommendedPosts->merge($popularPosts);
        }

        return view('post.show', compact('post', 'recommendedPosts'));
    }
}
