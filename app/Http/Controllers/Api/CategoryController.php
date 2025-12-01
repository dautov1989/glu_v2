<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get list of leaf categories (without children) for content generation
     * 
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Category::where('is_active', true)
            ->whereDoesntHave('children')
            ->with('parent');

        // Filter by minimum posts count
        if ($request->has('min_posts')) {
            $query->has('posts', '>=', $request->min_posts);
        }

        // Filter by maximum posts count
        if ($request->has('max_posts')) {
            $query->has('posts', '<=', $request->max_posts);
        }

        // Get categories with posts count for sorting
        $categories = $query->get()->sortBy(function ($category) {
            return $category->posts()->count();
        })->values();

        return CategoryResource::collection($categories);
    }
}
