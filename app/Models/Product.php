<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'slug',
        'title',
        'description',
        'content',
        'image_url',
        'marketplace',
        'marketplace_url',
        'rating',
        'badge',
        'features',
        'review_text',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'features'  => 'array',
        'is_active' => 'boolean',
        'rating'    => 'decimal:1',
        'sort_order' => 'integer',
    ];

    /**
     * Доступные маркетплейсы.
     */
    public static function getMarketplaces(): array
    {
        return [
            'Wildberries'    => 'Wildberries',
            'Ozon'           => 'Ozon',
            'Яндекс Маркет'  => 'Яндекс Маркет',
            'ЕАПТЕКА'        => 'ЕАПТЕКА',
            'СберМегаМаркет' => 'СберМегаМаркет',
            'AliExpress'     => 'AliExpress',
        ];
    }

    /**
     * Доступные бейджи.
     */
    public static function getBadges(): array
    {
        return [
            '#ТОП_ВЫБОР'     => '#ТОП_ВЫБОР',
            '#ПОПУЛЯРНОЕ'    => '#ПОПУЛЯРНОЕ',
            '#БАЗОВЫЙ_УХОД'  => '#БАЗОВЫЙ_УХОД',
            '#НОВИНКА'       => '#НОВИНКА',
            '#РЕКОМЕНДУЕМ'   => '#РЕКОМЕНДУЕМ',
        ];
    }

    /**
     * Категория товара.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope: только активные.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: по категории.
     */
    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Авто-генерация slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->title);
            }
        });
    }
}
