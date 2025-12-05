<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateLink;
use App\Models\Category;
use Illuminate\Http\Request;

class AffiliateLinkController extends Controller
{
    /**
     * Display a listing of affiliate links.
     */
    public function index()
    {
        $links = AffiliateLink::with('category')
            ->latest()
            ->paginate(20);

        return view('admin.affiliate-links.index', compact('links'));
    }

    /**
     * Show the form for creating a new affiliate link.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)
            ->with('parent', 'children')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'title' => $category->title,
                    'hierarchy' => $this->buildCategoryPath($category),
                    'depth' => $this->getCategoryDepth($category),
                    'has_children' => $category->children->count() > 0,
                ];
            })
            ->sortBy('hierarchy')
            ->values();

        $platforms = AffiliateLink::getPlatforms();

        return view('admin.affiliate-links.create', compact('categories', 'platforms'));
    }

    /**
     * Store a newly created affiliate link.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'platform' => 'required|in:ozon,wildberries,aliexpress',
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'affiliate_url' => 'required|url',
            'anchor_text' => 'required|string|max:255',
            'placement_hint' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        AffiliateLink::create($validated);

        return redirect()
            ->route('admin.affiliate-links.index')
            ->with('success', 'Партнерская ссылка успешно создана');
    }

    /**
     * Show the form for editing the specified affiliate link.
     */
    public function edit(AffiliateLink $affiliateLink)
    {
        $categories = Category::where('is_active', true)
            ->with('parent', 'children')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'title' => $category->title,
                    'hierarchy' => $this->buildCategoryPath($category),
                    'depth' => $this->getCategoryDepth($category),
                    'has_children' => $category->children->count() > 0,
                ];
            })
            ->sortBy('hierarchy')
            ->values();

        $platforms = AffiliateLink::getPlatforms();

        return view('admin.affiliate-links.edit', compact('affiliateLink', 'categories', 'platforms'));
    }

    /**
     * Update the specified affiliate link.
     */
    public function update(Request $request, AffiliateLink $affiliateLink)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'platform' => 'required|in:ozon,wildberries,aliexpress',
            'product_name' => 'required|string|max:255',
            'product_description' => 'nullable|string',
            'affiliate_url' => 'required|url',
            'anchor_text' => 'required|string|max:255',
            'placement_hint' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $affiliateLink->update($validated);

        return redirect()
            ->route('admin.affiliate-links.index')
            ->with('success', 'Партнерская ссылка успешно обновлена');
    }

    /**
     * Remove the specified affiliate link.
     */
    public function destroy(AffiliateLink $affiliateLink)
    {
        $affiliateLink->delete();

        return redirect()
            ->route('admin.affiliate-links.index')
            ->with('success', 'Партнерская ссылка успешно удалена');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(AffiliateLink $affiliateLink)
    {
        $affiliateLink->update([
            'is_active' => !$affiliateLink->is_active
        ]);

        return back()->with('success', 'Статус изменен');
    }

    /**
     * Build category hierarchy path.
     */
    private function buildCategoryPath($category)
    {
        $path = [];
        $current = $category;

        while ($current) {
            array_unshift($path, $current->title);
            $current = $current->parent;
        }

        return implode(' > ', $path);
    }

    /**
     * Get category depth level.
     */
    private function getCategoryDepth($category)
    {
        $depth = 0;
        $current = $category;

        while ($current->parent) {
            $depth++;
            $current = $current->parent;
        }

        return $depth;
    }
}
