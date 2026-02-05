<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\BentoService;

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

        $posts = $postsQuery->paginate(10)->appends(['sort' => $sortBy]);

        // Подготовить данные для Bento Grid используя централизованный сервис
        $bentoData = BentoService::prepareData($posts, $posts->currentPage());

        if (request()->ajax()) {
            return response()->json([
                'desktop' => view('category.partials.desktop-items', ['bentoData' => $bentoData])->render(),
                'mobile' => view('category.partials.mobile-items', ['bentoData' => $bentoData])->render(),
                'nextPageUrl' => $posts->nextPageUrl()
            ]);
        }

        return view('category.show', compact('category', 'posts', 'sortBy', 'bentoData'));
    }

    // Методы prepareBentoData и generateExcerpt удалены, так как они теперь в BentoService

    /**
     * Определяет иконку на основе категории
     */
    private function getCategoryIcon($category)
    {
        if (!$category) {
            return 'default';
        }

        $iconMap = [
            'pitanie' => 'nutrition',
            'diety' => 'diet',
            'recepty' => 'recipe',
            'sport' => 'sport',
            'trenirovki' => 'workout',
            'gadzhety' => 'gadget',
            'tekhnologii' => 'technology',
            'glyukometry' => 'glucometer',
            'preparaty' => 'medicine',
            'insulin' => 'insulin',
            'zdorove' => 'health',
            'profilaktika' => 'prevention',
        ];

        $slug = $category->slug;

        // Проверяем прямое совпадение
        if (isset($iconMap[$slug])) {
            return $iconMap[$slug];
        }

        // Проверяем родительские категории
        $parent = $category->parent;
        while ($parent) {
            if (isset($iconMap[$parent->slug])) {
                return $iconMap[$parent->slug];
            }
            $parent = $parent->parent;
        }

        return 'default';
    }
}
