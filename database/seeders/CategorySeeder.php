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

            // Создание категории
            $category = Category::create([
                'parent_id' => $parentId,
                'title' => $item['title'],
                'slug' => $slug,
                'level' => $level,
                'order' => $order,
                'is_active' => true,
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
}
