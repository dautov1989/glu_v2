<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentSuggestionResource;
use App\Models\Category;
use App\Models\ContentSuggestion;
use App\Models\Post;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    /**
     * Get intelligent content suggestion for n8n
     */
    public function suggest()
    {
        // 1. Find category with least published posts (leaf categories only)
        $category = Category::where('is_active', true)
            ->whereDoesntHave('children')
            ->withCount([
                'posts' => function ($query) {
                    $query->where('is_published', true);
                }
            ])
            ->orderBy('posts_count', 'asc')
            ->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'No categories available for content generation'
            ], 404);
        }

        // 2. Get hierarchy
        $hierarchy = $this->buildCategoryHierarchy($category);

        // 3. Get existing titles
        $existingTitles = Post::where('category_id', $category->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->pluck('title')
            ->toArray();

        return response()->json([
            'success' => true,
            'task' => 'Придумать заголовок и написать статью',
            'context' => [
                'category_id' => $category->id,
                'category' => $category->title,
                'hierarchy' => $hierarchy,
                'existing_articles' => $existingTitles,
            ],
            'requirements' => [
                'output_format' => 'JSON',
                'json_structure' => [
                    'title' => 'Придуманный заголовок статьи',
                    'content' => 'HTML контент статьи (без тега h1)',
                    'meta_description' => 'SEO описание для meta тега (150-160 символов)',
                    'meta_keywords' => 'Ключевые слова через запятую (5-7 слов)'
                ],
                'styling' => 'Tailwind CSS',
                'structure' => [
                    'h2' => 'Заголовки разделов',
                    'p' => 'Параграфы',
                    'ul/ol' => 'Списки'
                ],
                'rules' => [
                    'Придумать цепляющий заголовок, которого нет в списке существующих',
                    'Вернуть ответ строго в формате JSON',
                    'В поле content не включать заголовок h1 (он будет взят из поля title)',
                    'meta_description должно быть кратким и информативным',
                    'meta_keywords должны быть релевантными теме статьи',
                    'Использовать простой и понятный язык',
                    'Включать практические советы',
                    'Не использовать переносы строк (\n) в HTML, только теги'
                ]
            ]
        ]);
    }

    /**
     * Build category hierarchy
     */
    private function buildCategoryHierarchy(Category $category)
    {
        $hierarchy = [];
        $current = $category;

        while ($current) {
            array_unshift($hierarchy, $current->title);
            $current = $current->parent;
        }

        return implode(' > ', $hierarchy);
    }
}
