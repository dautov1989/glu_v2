<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $slug = \Illuminate\Support\Str::slug($title);

        return [
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id ?? \App\Models\Category::create(['title' => 'Default', 'slug' => 'default'])->id,
            'title' => $title,
            'slug' => $slug,
            'excerpt' => $this->faker->paragraph,
            'content' => $this->faker->paragraphs(3, true),
            'image' => null,
            'is_published' => true,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'views' => $this->faker->numberBetween(0, 1000),
            'meta_title' => $title . ' | Glucosa',
            'meta_description' => $this->faker->sentence,
        ];
    }
}
