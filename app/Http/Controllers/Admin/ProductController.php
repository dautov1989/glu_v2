<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Список товаров.
     */
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Форма создания товара.
     */
    public function create()
    {
        $categories = $this->getCategoryList();
        $marketplaces = Product::getMarketplaces();
        $badges = Product::getBadges();

        return view('admin.products.create', compact('categories', 'marketplaces', 'badges'));
    }

    /**
     * Сохранение нового товара.
     */
    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        // Обработка features из динамических полей
        $validated['features'] = array_values(array_filter($request->input('features', [])));
        $validated['is_active'] = $request->has('is_active');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно создан');
    }

    /**
     * Форма редактирования товара.
     */
    public function edit(Product $product)
    {
        $categories = $this->getCategoryList();
        $marketplaces = Product::getMarketplaces();
        $badges = Product::getBadges();

        return view('admin.products.edit', compact('product', 'categories', 'marketplaces', 'badges'));
    }

    /**
     * Обновление товара.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $this->validateProduct($request, $product->id);

        $validated['features'] = array_values(array_filter($request->input('features', [])));
        $validated['is_active'] = $request->has('is_active');

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно обновлён');
    }

    /**
     * Удаление товара.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Товар успешно удалён');
    }

    /**
     * Переключение активности.
     */
    public function toggleActive(Product $product)
    {
        $product->update([
            'is_active' => !$product->is_active
        ]);

        return back()->with('success', 'Статус товара изменён');
    }

    /**
     * Валидация полей товара.
     */
    private function validateProduct(Request $request, ?int $ignoreId = null): array
    {
        $slugRule = 'nullable|string|max:255|unique:products,slug';
        if ($ignoreId) {
            $slugRule .= ',' . $ignoreId;
        }

        return $request->validate([
            'category_id'      => 'nullable|exists:categories,id',
            'slug'             => $slugRule,
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'content'          => 'nullable|string',
            'image_url'        => 'nullable|url|max:500',
            'marketplace'      => 'required|in:' . implode(',', array_keys(Product::getMarketplaces())),
            'marketplace_url'  => 'nullable|url|max:500',
            'rating'           => 'nullable|numeric|min:0|max:10',
            'badge'            => 'nullable|string|max:50',
            'review_text'      => 'nullable|string',
            'sort_order'       => 'nullable|integer|min:0',
            'is_active'        => 'sometimes|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
        ]);
    }

    /**
     * Получить список категорий с иерархией.
     */
    private function getCategoryList()
    {
        return Category::where('is_active', true)
            ->with('parent', 'children')
            ->get()
            ->map(function ($category) {
                return [
                    'id'           => $category->id,
                    'title'        => $category->title,
                    'hierarchy'    => $this->buildCategoryPath($category),
                    'depth'        => $this->getCategoryDepth($category),
                    'has_children' => $category->children->count() > 0,
                ];
            })
            ->sortBy('hierarchy')
            ->values();
    }

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
