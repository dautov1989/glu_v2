<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentSuggestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category' => [
                'id' => $this->category->id,
                'title' => $this->category->title,
                'slug' => $this->category->slug,
                'description' => $this->category->description,
                'posts_count' => $this->category->posts()->where('is_published', true)->count(),
                'parent' => $this->category->parent ? [
                    'id' => $this->category->parent->id,
                    'title' => $this->category->parent->title,
                ] : null,
            ],
            'topic' => [
                'suggested_title' => $this->suggested_title,
                'keywords' => $this->keywords,
                'content_guidelines' => $this->content_guidelines,
            ],
            'context' => [
                'existing_titles' => $this->category->posts()
                    ->where('is_published', true)
                    ->latest('published_at')
                    ->limit(10)
                    ->pluck('title')
                    ->toArray(),
            ],
        ];
    }
}
