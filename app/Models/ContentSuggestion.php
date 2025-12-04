<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentSuggestion extends Model
{
    protected $fillable = [
        'category_id',
        'suggested_title',
        'content_guidelines',
        'keywords',
        'is_used',
        'used_at',
        'priority',
    ];

    protected $casts = [
        'keywords' => 'array',
        'is_used' => 'boolean',
        'used_at' => 'datetime',
        'priority' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
