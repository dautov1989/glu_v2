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

        // 2. Check if there's an unused suggestion for this category
        $suggestion = ContentSuggestion::where('category_id', $category->id)
            ->where('is_used', false)
            ->orderBy('priority', 'desc')
            ->first();

        // 3. If no predefined suggestion, generate one dynamically
        if (!$suggestion) {
            $suggestion = $this->generateDynamicSuggestion($category);
        }

        return response()->json([
            'success' => true,
            'suggestion' => new ContentSuggestionResource($suggestion)
        ]);
    }

    /**
     * Mark a suggestion as used
     */
    public function markUsed($id)
    {
        $suggestion = ContentSuggestion::findOrFail($id);

        $suggestion->update([
            'is_used' => true,
            'used_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Suggestion marked as used'
        ]);
    }

    /**
     * Generate dynamic suggestion
     */
    private function generateDynamicSuggestion(Category $category)
    {
        // Get existing titles
        $existingTitles = Post::where('category_id', $category->id)
            ->pluck('title')
            ->toArray();

        // Get template
        $template = $this->selectBestTemplate($category);
        $suggestedTitle = $this->fillTemplate($template, $category);

        // Ensure uniqueness
        $counter = 1;
        $originalTitle = $suggestedTitle;
        while ($this->isSimilarToExisting($suggestedTitle, $existingTitles)) {
            $suggestedTitle = $originalTitle . ' - Часть ' . $counter;
            $counter++;
        }

        // Create guidelines
        $guidelines = $this->generateGuidelines($category, $suggestedTitle);

        // Create suggestion
        $suggestion = new ContentSuggestion([
            'category_id' => $category->id,
            'suggested_title' => $suggestedTitle,
            'content_guidelines' => $guidelines,
            'keywords' => $this->extractKeywords($category, $suggestedTitle),
            'priority' => 1,
        ]);

        $suggestion->setRelation('category', $category);

        return $suggestion;
    }

    /**
     * Select template based on category
     */
    private function selectBestTemplate(Category $category)
    {
        $parentTitle = $category->parent ? mb_strtolower($category->parent->title) : '';
        $categoryTitle = mb_strtolower($category->title);

        $templatesByContext = [
            'медицинская' => [
                'Как {действие} {состояние}: полное руководство',
                '{тема}: симптомы, причины и лечение',
                '{число} важных фактов о {тема}',
            ],
            'рецепты' => [
                '{число} полезных рецептов для диабетиков',
                'Меню на неделю при {состояние}',
                'Продукты {характеристика} для диабетиков',
            ],
            'спорт' => [
                '{число} упражнений для диабетиков',
                'Физическая активность при {состояние}',
            ],
            'лекарства' => [
                'Как правильно принимать {препарат}',
                'Инсулинотерапия при {состояние}',
            ],
            'default' => [
                'Полное руководство по {тема}',
                'Как {действие} при {состояние}',
                'Топ-{число} советов по {тема}',
            ],
        ];

        $templates = $templatesByContext['default'];

        foreach ($templatesByContext as $context => $contextTemplates) {
            if (Str::contains($parentTitle, $context) || Str::contains($categoryTitle, $context)) {
                $templates = $contextTemplates;
                break;
            }
        }

        return $templates[array_rand($templates)];
    }

    /**
     * Fill template
     */
    private function fillTemplate($template, Category $category)
    {
        $categoryTitle = $category->title;

        $replacements = [
            '{действие}' => ['контролировать', 'управлять', 'лечить'],
            '{состояние}' => [$categoryTitle, 'диабете'],
            '{число}' => ['5', '7', '10'],
            '{тема}' => [$categoryTitle, strtolower($categoryTitle)],
            '{цель}' => ['контроль глюкозы', 'здоровье'],
            '{блюдо}' => ['полезный завтрак', 'диетический ужин'],
            '{характеристика}' => ['с низким ГИ', 'без сахара'],
            '{активность}' => ['спортом', 'фитнесом'],
            '{препарат}' => ['инсулин', 'метформин'],
        ];

        foreach ($replacements as $placeholder => $options) {
            if (Str::contains($template, $placeholder)) {
                $template = str_replace($placeholder, $options[array_rand($options)], $template);
            }
        }

        return $template;
    }

    /**
     * Check similarity
     */
    private function isSimilarToExisting($title, $existingTitles)
    {
        $titleLower = mb_strtolower($title);

        foreach ($existingTitles as $existing) {
            $existingLower = mb_strtolower($existing);

            if ($titleLower === $existingLower) {
                return true;
            }

            $titleWords = explode(' ', $titleLower);
            $existingWords = explode(' ', $existingLower);
            $commonWords = array_intersect($titleWords, $existingWords);

            if (count($commonWords) / max(count($titleWords), count($existingWords)) > 0.6) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate SIMPLIFIED guidelines for AI
     */
    private function generateGuidelines(Category $category, $title)
    {
        $keywords = $this->extractKeywords($category, $title);
        $hierarchy = $this->buildCategoryHierarchy($category);

        // Получить существующие статьи
        $existingArticles = Post::where('category_id', $category->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->limit(10)
            ->pluck('title')
            ->toArray();

        return "ЗАДАНИЕ: Напиши SEO-оптимизированную статью\n\n" .
            "═══════════════════════════════════════\n\n" .
            "📍 ТЕМА СТАТЬИ:\n" .
            "{$title}\n\n" .
            "═══════════════════════════════════════\n\n" .
            "📂 ИЕРАРХИЯ КАТЕГОРИЙ (контекст):\n" .
            $hierarchy . "\n\n" .
            "═══════════════════════════════════════\n\n" .
            "📚 СУЩЕСТВУЮЩИЕ СТАТЬИ:\n" .
            (count($existingArticles) > 0
                ? "⚠️ НЕ ПОВТОРЯЙ эти темы:\n" . implode("\n", array_map(fn($t) => "- {$t}", $existingArticles))
                : "✅ Это первая статья в категории") . "\n\n" .
            "═══════════════════════════════════════\n\n" .
            "🎯 SEO ТРЕБОВАНИЯ:\n" .
            "• Ключевые слова: " . implode(', ', array_slice($keywords, 0, 3)) . "\n" .
            "• Объем: 800-1200 слов\n" .
            "• Заголовок H1: включи основное ключевое слово\n" .
            "• Используй подзаголовки H2 и H3\n\n" .
            "═══════════════════════════════════════\n\n" .
            "📝 СТРУКТУРА:\n\n" .
            "1. ВВЕДЕНИЕ (2-3 абзаца)\n" .
            "   - Почему эта тема важна\n" .
            "   - Что узнает читатель\n\n" .
            "2. ОСНОВНАЯ ЧАСТЬ (3-4 раздела с H2)\n" .
            "   - Подробная информация\n" .
            "   - Практические примеры\n" .
            "   - Используй списки\n\n" .
            "3. ПРАКТИЧЕСКИЕ СОВЕТЫ (H2)\n" .
            "   - Что делать\n" .
            "   - Чего избегать\n\n" .
            "4. ЗАКЛЮЧЕНИЕ (1-2 абзаца)\n" .
            "   - Краткое резюме\n" .
            "   - Призыв к врачу\n\n" .
            "═══════════════════════════════════════\n\n" .
            "✨ ФОРМАТ ВЫВОДА:\n" .
            "⚠️ ОБЯЗАТЕЛЬНО используй HTML теги!\n\n" .
            "• <h1> для главного заголовка\n" .
            "• <h2> для подзаголовков разделов\n" .
            "• <h3> для подподзаголовков\n" .
            "• <p> для абзацев\n" .
            "• <ul> и <li> для списков\n" .
            "• <strong> для важных моментов\n" .
            "• <em> для акцентов\n\n" .
            "⚠️ ВАЖНО ПРО ФОРМАТИРОВАНИЕ:\n" .
            "• НЕ используй \\n или \\r\\n в тексте!\n" .
            "• Используй только HTML теги для форматирования\n" .
            "• Каждый абзац оборачивай в <p></p>\n" .
            "• Не добавляй символы переноса строк\n\n" .
            "💎 TAILWIND CSS (опционально):\n" .
            "Можешь добавлять Tailwind классы для красоты:\n\n" .
            "• <p class=\"mb-4 text-gray-700\"> - для абзацев\n" .
            "• <ul class=\"list-disc pl-6 mb-4\"> - для списков\n" .
            "• <strong class=\"font-semibold text-blue-600\"> - для акцентов\n" .
            "• <div class=\"bg-blue-50 border-l-4 border-blue-500 p-4 mb-4\"> - для важных блоков\n\n" .
            "Пример:\n" .
            "<h1>Заголовок статьи</h1>\n" .
            "<p class=\"mb-4 text-gray-700\">Текст введения...</p>\n" .
            "<h2>Раздел 1</h2>\n" .
            "<p class=\"mb-4\">Текст раздела...</p>\n" .
            "<ul class=\"list-disc pl-6 mb-4\">\n" .
            "  <li>Пункт списка</li>\n" .
            "</ul>\n" .
            "<div class=\"bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4\">\n" .
            "  <strong>⚠️ Важно:</strong> Проконсультируйтесь с врачом\n" .
            "</div>\n\n" .
            "═══════════════════════════════════════\n\n" .
            "⚠️ ВАЖНО:\n" .
            "• Простой язык для пациентов\n" .
            "• Только проверенная информация\n" .
            "• НЕ давай конкретных назначений\n" .
            "• Рекомендуй консультацию с врачом\n\n" .
            "👥 АУДИТОРИЯ: Люди с диабетом и их близкие";
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

        $formatted = "";
        foreach ($hierarchy as $index => $name) {
            $indent = str_repeat("  ", $index);
            $arrow = $index > 0 ? "└─ " : "";
            $formatted .= $indent . $arrow . $name . "\n";
        }

        return trim($formatted);
    }

    /**
     * Extract keywords
     */
    private function extractKeywords(Category $category, $title = null)
    {
        $keywords = [];

        $keywords[] = mb_strtolower($category->title);

        if ($category->parent) {
            $keywords[] = mb_strtolower($category->parent->title);
        }

        if ($title) {
            $titleWords = explode(' ', mb_strtolower($title));
            $stopWords = ['как', 'при', 'для', 'что', 'это', 'или', 'и', 'в', 'на', 'с', 'по', 'о'];
            foreach ($titleWords as $word) {
                $word = trim($word, ',:;.!?');
                if (mb_strlen($word) > 3 && !in_array($word, $stopWords)) {
                    $keywords[] = $word;
                }
            }
        }

        $keywords = array_merge($keywords, ['диабет', 'глюкоза', 'инсулин']);

        return array_values(array_unique($keywords));
    }
}
