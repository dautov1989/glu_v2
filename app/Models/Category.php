<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'level',
        'order',
        'is_active',
        'description',
        'meta_title',
        'meta_description',
        'icon',
        'image',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'level' => 'integer',
        'order' => 'integer',
    ];

    /**
     * Родительская категория
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Дочерние категории
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('order');
    }

    /**
     * Все дочерние категории рекурсивно
     */
    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    /**
     * Получить все корневые категории (уровень 0)
     */
    public static function getRootCategories()
    {
        return self::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    /**
     * Получить полное дерево категорий
     */
    public static function getTree()
    {
        return self::whereNull('parent_id')
            ->where('is_active', true)
            ->with('childrenRecursive')
            ->orderBy('order')
            ->get();
    }

    /**
     * Получить хлебные крошки (путь от корня до текущей категории)
     */
    public function getBreadcrumbs(): array
    {
        $breadcrumbs = [];
        $category = $this;

        while ($category) {
            array_unshift($breadcrumbs, $category);
            $category = $category->parent;
        }

        return $breadcrumbs;
    }

    /**
     * Автоматическая генерация slug при создании
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('title') && empty($category->slug)) {
                $category->slug = Str::slug($category->title);
            }
        });
    }

    /**
     * Проверка, является ли категория корневой
     */
    public function isRoot(): bool
    {
        return $this->parent_id === null;
    }

    /**
     * Проверка, имеет ли категория дочерние элементы
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }
}
