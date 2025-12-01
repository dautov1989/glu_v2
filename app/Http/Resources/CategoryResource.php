<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'posts_count' => $this->posts()->where('is_published', true)->count(),
            'total_posts_count' => $this->posts()->count(),
            'parent' => $this->parent ? [
                'id' => $this->parent->id,
                'title' => $this->parent->title,
                'slug' => $this->parent->slug,
            ] : null,
            'last_post_date' => $this->posts()
                ->where('is_published', true)
                ->orderBy('published_at', 'desc')
                ->value('published_at'),
        ];
    }
}
