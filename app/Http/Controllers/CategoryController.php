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

        $posts = $postsQuery->paginate(9)->appends(['sort' => $sortBy]);

        // Подготовить данные для Bento Grid используя текущую страницу пагинации
        $bentoData = $this->prepareBentoData($posts, $posts->currentPage());

        if (request()->ajax()) {
            return response()->json([
                'desktop' => view('category.partials.desktop-items', ['bentoData' => $bentoData])->render(),
                'mobile' => view('category.partials.mobile-items', ['bentoData' => $bentoData])->render(),
                'nextPageUrl' => $posts->nextPageUrl()
            ]);
        }

        return view('category.show', compact('category', 'posts', 'sortBy', 'bentoData'));
    }

    /**
     * Подготовить данные для Bento Grid
     * Группирует статьи по типам блоков (L/M/S) и определяет бейджи
     * Принимает пагинированную коллекцию или LengthAwarePaginator
     */
    private function prepareBentoData($postsPaginator, $page = 1)
    {
        // Берем посты только текущей страницы
        // Используем items(), если это пагинатор, или саму коллекцию
        $currentPosts = $postsPaginator instanceof \Illuminate\Pagination\LengthAwarePaginator
            ? $postsPaginator->getCollection()
            : $postsPaginator;

        // Важно: Bento Grid внутри себя хочет видеть самые просматриваемые крупнее.
        // Но мы не можем менять порядок сортировки, выбранный пользователем (например "Сначала новые").
        // Если мы пересортируем страницу по просмотрам, пользователь потеряет хронологию.

        // Компромисс:
        // 1. Мы сохраняем набор статей текущей страницы.
        // 2. Но ДЛЯ ВИЗУАЛИЗАЦИИ мы можем поставить самую популярную из ЭТОЙ ВЫБОРКИ на первое место (Large).
        // ИЛИ
        // Мы просто выводим их в том порядке, который выбрал юзер.
        // Если юзер выбрал "Новые", то Large будет САМАЯ НОВАЯ статья. Это логично.
        // Если юзер выбрал "Популярные", то Large будет САМАЯ ПОПУЛЯРНАЯ.

        // Так что просто используем коллекцию как есть, не пересортировывая принудительно по просмотрам,
        // иначе сортировка "Сначала новые" будет выглядеть хаотично (первой будет старая популярная).

        $processedPosts = $currentPosts->map(function ($post, $index) use ($page) {
            // Определяем тип блока
            // Large только на 1-й странице и только 1-й элемент
            if ($page === 1 && $index === 0) {
                $post->bentoSize = 'large';
            } elseif (
                ($page === 1 && $index >= 1 && $index <= 3) || // Стр 1: 2-4 элементы
                ($page > 1 && $index % 5 === 0) // Стр > 1: Каждый 5-й элемент делаем средним для разнообразия, но не Large
            ) {
                $post->bentoSize = 'medium';
            } else {
                $post->bentoSize = 'small';
            }

            // Определяем бейдж
            // Логика бейджей должна быть относительной контента
            $isTopViewed = false; // Тут сложнее определить глобальный топ на странице
            $newThreshold = now()->subDays(30); // Расширим до 30 дней для "New"
            $isNew = ($post->published_at && $post->published_at >= $newThreshold);

            // Просто ставим бейджи по порядку для красоты, или по свойствам
            if ($page === 1 && $index === 0) {
                // Первый элемент всегда выделяем
                $post->bentoBadge = 'top';
            } elseif ($post->bentoSize === 'medium') {
                // Все Medium блоки (широкие) помечаем как Популярные для красоты
                $post->bentoBadge = 'popular';
            } elseif ($isNew) {
                $post->bentoBadge = 'new';
            } elseif ($post->views > 1000) { // Для остальных страниц, если реально популярное
                $post->bentoBadge = 'popular';
            } else {
                $post->bentoBadge = null;
            }

            // Fallback для описания
            if (empty($post->meta_description)) {
                $post->fallbackDescription = $this->generateExcerpt($post->content ?? $post->excerpt, 150);
            } else {
                $post->fallbackDescription = $post->meta_description;
            }

            // Fallback для keywords (тегов)
            if (empty($post->meta_keywords)) {
                $post->fallbackKeywords = [$post->category->title ?? 'Диабет'];
            } else {
                $keywords = explode(',', $post->meta_keywords);
                $post->fallbackKeywords = array_slice(array_map('trim', $keywords), 0, 4);
            }

            // Определяем градиент на основе ID поста (рандомный выбор)
            $gradients = ['blue', 'teal', 'steel', 'indigo'];
            $post->bentoGradient = $gradients[$post->id % 4];

            // Определяем рандомную иконку на основе ID поста
            $allIcons = ['nutrition', 'diet', 'recipe', 'sport', 'workout', 'gadget', 'technology', 'glucometer', 'medicine', 'insulin', 'health', 'prevention'];
            $post->bentoIcon = $allIcons[$post->id % count($allIcons)];

            return $post;
        });

        return [
            'large' => $processedPosts->where('bentoSize', 'large')->first(), // Будет null на стр > 1
            'medium' => $processedPosts->where('bentoSize', 'medium'),
            'small' => $processedPosts->where('bentoSize', 'small'),
            'all' => $processedPosts, // Полный список для итерации при подгрузке
        ];
    }

    /**
     * Генерирует короткое описание из контента
     */
    private function generateExcerpt($content, $length = 150)
    {
        $text = strip_tags($content);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        if (mb_strlen($text) <= $length) {
            return $text;
        }

        return mb_substr($text, 0, $length) . '...';
    }

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
