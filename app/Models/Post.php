<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'is_published',
        'published_at',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Boot method for automatic slug generation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = \Illuminate\Support\Str::slug($post->title);
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = \Illuminate\Support\Str::slug($post->title);
            }
        });
    }
    /**
     * Get image url with fallback to category placeholder
     */
    public function getImageAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        // Return category specific placeholder
        if ($this->category) {
            // Check direct category match
            $slug = $this->category->slug;
            $placeholderPath = 'images/placeholders/' . $slug . '.png';

            if (file_exists(public_path($placeholderPath))) {
                return asset($placeholderPath);
            }

            // Check parent category match (traverse up)
            $parent = $this->category->parent;
            while ($parent) {
                $slug = $parent->slug;
                $placeholderPath = 'images/placeholders/' . $slug . '.png';
                if (file_exists(public_path($placeholderPath))) {
                    return asset($placeholderPath);
                }
                $parent = $parent->parent;
            }
        }

        // Global default fallback
        return asset('images/medical_placeholder.png');
    }
}
