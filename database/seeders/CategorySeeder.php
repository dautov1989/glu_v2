<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Очистка таблицы перед заполнением
        Category::query()->delete();

        // Загрузка данных из JSON файла
        $jsonPath = base_path('cat.json');

        if (!file_exists($jsonPath)) {
            $this->command->error('Файл cat.json не найден!');
            return;
        }

        $categories = json_decode(file_get_contents($jsonPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Ошибка при разборе JSON: ' . json_last_error_msg());
            return;
        }

        $this->command->info('Начинаем импорт категорий...');

        // Рекурсивная функция для создания категорий
        $this->createCategories($categories, null, 0);

        $this->command->info('Импорт категорий завершен успешно!');
        $this->command->info('Всего создано категорий: ' . Category::count());
    }

    /**
     * Рекурсивное создание категорий
     *
     * @param array $items Массив категорий
     * @param int|null $parentId ID родительской категории
     * @param int $level Уровень вложенности
     * @param int $order Порядок сортировки
     */
    private function createCategories(array $items, ?int $parentId = null, int $level = 0, int &$order = 0): void
    {
        foreach ($items as $index => $item) {
            $order++;

            // Создание slug из title
            $slug = $this->generateUniqueSlug($item['title'], $parentId);

            // Генерация SEO-полей
            $seoData = $this->generateSeoFields($item['title'], $level, $parentId);

            // Создание категории
            $category = Category::create([
                'parent_id' => $parentId,
                'title' => $item['title'],
                'slug' => $slug,
                'level' => $level,
                'order' => $order,
                'is_active' => true,
                'description' => $seoData['description'],
                'meta_title' => $seoData['meta_title'],
                'meta_description' => $seoData['meta_description'],
            ]);

            $this->command->info("Создана категория: {$item['title']} (уровень {$level})");

            // Рекурсивное создание подкатегорий
            if (isset($item['subitems']) && is_array($item['subitems']) && count($item['subitems']) > 0) {
                $childOrder = 0;
                $this->createCategories($item['subitems'], $category->id, $level + 1, $childOrder);
            }
        }
    }

    /**
     * Генерация уникального slug
     *
     * @param string $title Название категории
     * @param int|null $parentId ID родительской категории
     * @return string
     */
    private function generateUniqueSlug(string $title, ?int $parentId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Проверка уникальности slug
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Генерация SEO-полей для категории
     *
     * @param string $title Название категории
     * @param int $level Уровень вложенности
     * @param int|null $parentId ID родительской категории
     * @return array
     */
    private function generateSeoFields(string $title, int $level, ?int $parentId = null): array
    {
        // Получаем родительскую категорию для контекста
        $parentCategory = $parentId ? Category::find($parentId) : null;
        $parentTitle = $parentCategory ? $parentCategory->title : '';

        // Базовые шаблоны для разных уровней
        $description = $this->generateDescription($title, $level, $parentTitle);
        $metaTitle = $this->generateMetaTitle($title, $level, $parentTitle);
        $metaDescription = $this->generateMetaDescription($title, $level, $parentTitle);

        return [
            'description' => $description,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
        ];
    }

    /**
     * Генерация description для категории
     */
    private function generateDescription(string $title, int $level, string $parentTitle): string
    {
        if ($level === 0) {
            // Корневые категории - подробное описание
            return "Полная информация о теме «{$title}» для людей с сахарным диабетом. Практические советы, рекомендации врачей и актуальные материалы от экспертов.";
        } elseif ($level === 1) {
            // Второй уровень - связь с родителем
            return "Раздел «{$title}» в категории {$parentTitle}. Подробные материалы, советы специалистов и практические рекомендации для людей с диабетом.";
        } elseif ($level === 2) {
            // Третий уровень - более конкретное описание
            return "Информация о теме «{$title}». Экспертные статьи, практические советы и рекомендации для эффективного управления диабетом.";
        } else {
            // Четвертый уровень - краткое описание
            return "Подробная информация о теме «{$title}» для людей с сахарным диабетом.";
        }
    }

    /**
     * Генерация meta_title для категории
     */
    private function generateMetaTitle(string $title, int $level, string $parentTitle): string
    {
        if ($level === 0) {
            // Корневые категории
            return "{$title} при диабете - Полное руководство | Glucosa";
        } elseif ($level === 1) {
            // Второй уровень
            return "{$title} - {$parentTitle} | Информация о диабете";
        } elseif ($level === 2) {
            // Третий уровень
            return "{$title} при диабете | Советы и рекомендации";
        } else {
            // Четвертый уровень
            return "{$title} | Glucosa - Всё о диабете";
        }
    }

    /**
     * Генерация meta_description для категории
     */
    private function generateMetaDescription(string $title, int $level, string $parentTitle): string
    {
        $baseKeywords = [
            'сахарный диабет',
            'диабет 1 типа',
            'диабет 2 типа',
            'управление диабетом',
            'советы эндокринолога',
        ];

        if ($level === 0) {
            return "Всё о теме «{$title}» при сахарном диабете ➤ Экспертные статьи ✓ Практические советы ✓ Рекомендации врачей ✓ Актуальная информация для людей с диабетом.";
        } elseif ($level === 1) {
            return "{$title} в разделе {$parentTitle} ➤ Подробные материалы о диабете ✓ Советы специалистов ✓ Практические рекомендации ✓ Проверенная информация.";
        } elseif ($level === 2) {
            return "Подробная информация о теме «{$title}» ➤ Экспертные статьи о диабете ✓ Практические советы ✓ Рекомендации эндокринологов ✓ Актуальные материалы.";
        } else {
            return "{$title} при сахарном диабете ➤ Полезная информация ✓ Советы врачей ✓ Практические рекомендации для людей с диабетом.";
        }
    }
}
