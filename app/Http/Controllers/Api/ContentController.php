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
                'content_requirements' => [
                    'min_length' => '1500+ слов для медицинских тем',
                    'tone' => 'Профессиональный, но доступный для широкой аудитории',
                    'language' => 'Простой и понятный русский язык без сложной медицинской терминологии',
                    'structure' => 'Логичная структура с введением, основной частью и заключением'
                ],
                'seo_requirements' => [
                    'headings' => [
                        'Использовать правильную иерархию заголовков H2 → H3 → H4',
                        'H1 не использовать (будет из поля title)',
                        'Каждый раздел должен иметь четкий заголовок H2',
                        'Подразделы оформлять через H3',
                        'Включать ключевые слова в заголовки естественным образом'
                    ],
                    'keywords' => [
                        'Естественно включать ключевые слова в текст (плотность 1-2%)',
                        'Использовать синонимы и LSI-ключевые слова',
                        'Избегать переспама ключевыми словами',
                        'Ключевые слова в первом абзаце обязательно'
                    ],
                    'content_structure' => [
                        'Использовать маркированные списки (ul) для перечислений',
                        'Использовать нумерованные списки (ol) для пошаговых инструкций',
                        'Добавлять таблицы для сравнения данных (если уместно)',
                        'Выделять важные моменты через <strong> или <em>',
                        'Разбивать длинные абзацы (максимум 3-4 предложения)'
                    ],
                    'internal_linking' => [
                        'НЕ добавлять внутренние ссылки автоматически',
                        'Оставить места для потенциальных внутренних ссылок (упоминания смежных тем)'
                    ],
                    'readability' => [
                        'Короткие предложения (15-20 слов)',
                        'Активный залог вместо пассивного',
                        'Конкретные примеры и практические советы',
                        'Избегать воды и общих фраз'
                    ]
                ],
                'quality_rules' => [
                    'Придумать цепляющий, но информативный заголовок',
                    'Заголовок должен быть уникальным (не из списка existing_articles)',
                    'Вернуть ответ строго в формате JSON',
                    'meta_description должно содержать призыв к действию',
                    'meta_keywords - только релевантные термины (5-7 штук)',
                    'Проверить медицинскую точность информации',
                    'Добавить disclaimer о консультации с врачом (где уместно)',
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
