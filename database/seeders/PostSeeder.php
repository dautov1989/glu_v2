<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем категории, у которых нет дочерних элементов (листья дерева)
        $categories = \App\Models\Category::doesntHave('children')->get();

        foreach ($categories as $category) {
            \App\Models\Post::factory()
                ->count(rand(5, 10))
                ->create([
                    'category_id' => $category->id,
                ]);
        }
    }
}
