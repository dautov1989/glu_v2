<?php

namespace App\Services\Seo;

use Illuminate\Support\Str;

class InternalLinker
{
    /**
     * Список ключевых слов и ссылок.
     * В будущем можно вынести в базу данных или конфиг.
     */
    protected array $keywords = [
        'диабет' => '/search?q=диабет',
        'инсулин' => '/search?q=инсулин',
        'глюкоз' => '/search?q=глюкоза', // частичное совпадение
        'сахар' => '/search?q=сахар',
        'диет' => '/category/pitanie', // предположим, есть такая категория
        'питани' => '/category/pitanie',
        'спорт' => '/category/sport',
    ];

    /**
     * Обрабатывает контент и добавляет ссылки.
     */
    public function link(string $content): string
    {
        // Если контент пустой, возвращаем как есть
        if (empty($content)) {
            return '';
        }

        // Проходим по всем ключевым словам
        foreach ($this->keywords as $keyword => $url) {
            // Используем регулярное выражение для поиска слова (регистронезависимо, только целые слова или начала слов)
            // Ограничиваем замену только первым вхождением (limit=1), чтобы не спамить ссылками
            $pattern = '/(?<!href="|">)\b(' . preg_quote($keyword, '/') . '\w*)\b/ui';

            $content = preg_replace_callback($pattern, function ($matches) use ($url) {
                return '<a href="' . $url . '" class="text-cyan-600 hover:text-cyan-800 dark:text-cyan-400 dark:hover:text-cyan-300 underline decoration-cyan-200 dark:decoration-cyan-800 underline-offset-2 transition-colors">' . $matches[0] . '</a>';
            }, $content, 1); // 1 = только одна замена на ключевое слово
        }

        return $content;
    }
}
