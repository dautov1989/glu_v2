<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BentoService
{
    /**
     * Подготовить данные для Bento Grid
     * Группирует статьи по типам блоков (L/M/S) и определяет бейджи
     * Принимает пагинированную коллекцию или LengthAwarePaginator
     */
    public static function prepareData($postsPaginator, $page = 1)
    {
        // Берем посты только текущей страницы
        // Используем items(), если это пагинатор, или саму коллекцию
        $currentPosts = $postsPaginator instanceof LengthAwarePaginator
            ? $postsPaginator->getCollection()
            : $postsPaginator;

        // Сортируем коллекцию внутри, чтобы самые популярные из этой выборки были первыми
        // Это обеспечит постановку самого популярного поста на место Large (Top-1)
        $sortedPosts = $currentPosts->sortByDesc('views')->values();

        $processedPosts = $sortedPosts->map(function ($post, $index) use ($page) {
            // Определяем тип блока
            // Large только на 1-й странице (или первой порции) и только 1-й по популярности элемент
            if ($page === 1 && $index === 0) {
                $post->bentoSize = 'large';
            } elseif (
                ($page === 1 && $index >= 1 && $index <= 3) || // Стр 1: 2-4 по популярности элементы
                ($page > 1 && $index % 5 === 0) // Стр > 1: Разнообразие
            ) {
                $post->bentoSize = 'medium';
            } else {
                $post->bentoSize = 'small';
            }

            // Определяем бейдж
            $newThreshold = now()->subDays(30);
            $isNew = ($post->published_at && $post->published_at >= $newThreshold);

            if ($page === 1 && $index === 0) {
                // Первый элемент всегда выделяем
                $post->bentoBadge = 'top';
            } elseif ($post->bentoSize === 'medium') {
                // Все Medium блоки (широкие) помечаем как Популярные для красоты
                $post->bentoBadge = 'popular';
            } elseif ($isNew) {
                $post->bentoBadge = 'new';
            } elseif ($post->views > 1000) {
                $post->bentoBadge = 'popular';
            } else {
                $post->bentoBadge = null;
            }

            // Fallback для описания
            if (empty($post->meta_description)) {
                $post->fallbackDescription = self::generateExcerpt($post->content ?? $post->excerpt, 150);
            } else {
                $post->fallbackDescription = $post->meta_description;
            }

            // Fallback для keywords
            if (empty($post->meta_keywords)) {
                // Если есть связь с категорией, берем её название
                $post->fallbackKeywords = [$post->category->title ?? 'Диабет'];
            } else {
                $keywords = explode(',', $post->meta_keywords);
                $post->fallbackKeywords = array_slice(array_map('trim', $keywords), 0, 4);
            }

            // Градиенты и иконки
            $gradients = ['blue', 'teal', 'steel', 'indigo'];
            $post->bentoGradient = $gradients[$post->id % 4];

            $allIcons = ['nutrition', 'diet', 'recipe', 'sport', 'workout', 'gadget', 'technology', 'glucometer', 'medicine', 'insulin', 'health', 'prevention'];
            $post->bentoIcon = $allIcons[$post->id % count($allIcons)];

            return $post;
        });

        return [
            'large' => $processedPosts->where('bentoSize', 'large')->first(),
            'medium' => $processedPosts->where('bentoSize', 'medium'),
            'small' => $processedPosts->where('bentoSize', 'small'),
            'all' => $processedPosts,
        ];
    }

    /**
     * Генерирует короткое описание из контента
     */
    private static function generateExcerpt($content, $length = 150)
    {
        $text = strip_tags($content ?? '');
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        if (mb_strlen($text) <= $length) {
            return $text;
        }

        return mb_substr($text, 0, $length) . '...';
    }
}
