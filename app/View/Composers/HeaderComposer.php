<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class HeaderComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $categories = $this->getCategoriesTree();

        $view->with('megaMenuCategories', $categories);
    }

    /**
     * Получить дерево категорий в формате для мега-меню
     */
    private function getCategoriesTree(): array
    {
        // Получаем корневые категории с их дочерними элементами
        $rootCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->with([
                'childrenRecursive' => function ($query) {
                    $query->where('is_active', true)->orderBy('order');
                }
            ])
            ->orderBy('order')
            ->get();

        return $rootCategories->map(function ($category) {
            return $this->formatCategoryForMenu($category);
        })->toArray();
    }

    /**
     * Форматировать категорию для мега-меню
     */
    private function formatCategoryForMenu(Category $category): array
    {
        return [
            'id' => $category->slug,
            'label' => $category->title,
            'slug' => $category->slug,
            'url' => route('category.show', $category->slug),
            'children' => $category->children->map(function ($child) {
                return [
                    'label' => $child->title,
                    'slug' => $child->slug,
                    'url' => route('category.show', $child->slug),
                    'children' => $child->children->map(function ($grandChild) {
                        return [
                            'label' => $grandChild->title,
                            'slug' => $grandChild->slug,
                            'url' => route('category.show', $grandChild->slug),
                            'children' => $grandChild->children->map(function ($greatGrandChild) {
                                return [
                                    'label' => $greatGrandChild->title,
                                    'slug' => $greatGrandChild->slug,
                                    'url' => route('category.show', $greatGrandChild->slug),
                                ];
                            })->toArray(),
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];
    }
}
