<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    const PLATFORM_OZON = 'ozon';
    const PLATFORM_WILDBERRIES = 'wildberries';
    const PLATFORM_ALIEXPRESS = 'aliexpress';

    protected $fillable = [
        'category_id',
        'platform',
        'product_name',
        'product_description',
        'affiliate_url',
        'anchor_text',
        'placement_hint',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the affiliate link.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope to get only active links.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get links for a specific category.
     */
    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Get available platforms.
     */
    public static function getPlatforms()
    {
        return [
            self::PLATFORM_OZON => 'Ozon',
            self::PLATFORM_WILDBERRIES => 'Wildberries',
            self::PLATFORM_ALIEXPRESS => 'AliExpress',
        ];
    }
}
