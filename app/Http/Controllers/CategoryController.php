<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    /**
     * Display a listing of all categories (category index page).
     * 
     * GET /categories
     * 
     * Shows hierarchical category structure with service counts.
     */
    public function index()
    {
        // Get root categories (no parent) with their children
        $categories = Cache::remember('category_tree', 3600, function () {
            return Category::with(['children' => function ($query) {
                $query->where('visible', true)
                    ->withCount(['services' => function ($q) {
                        $q->where('visible', true)->where('available', true);
                    }])
                    ->orderBy('order');
            }])
            ->visible()
            ->whereNull('parent_id') // Root categories only
            ->withCount(['services' => function ($q) {
                $q->where('visible', true)->where('available', true);
            }])
            ->orderBy('order')
            ->get();
        });

        return view('categories.index', compact('categories'));
    }

    /**
     * Display services in a specific category.
     * 
     * GET /categories/{slug}
     * 
     * Shows all services within the category and its sub-categories.
     */
    public function show(string $slug)
    {
        $category = Category::with(['children'])
            ->where('slug', $slug)
            ->where('visible', true)
            ->firstOrFail();

        // Get all descendant category IDs (including current category)
        $categoryIds = collect([$category->id])
            ->merge($this->getDescendantIds($category))
            ->unique()
            ->values();

        // Get services in this category and all sub-categories
        $services = Service::with(['categories', 'variants'])
            ->where('visible', true)
            ->where('available', true)
            ->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get sub-categories for navigation
        $subCategories = $category->children()
            ->where('visible', true)
            ->withCount(['services' => function ($q) {
                $q->where('visible', true)->where('available', true);
            }])
            ->orderBy('order')
            ->get();

        // Get breadcrumb trail (ancestors)
        $breadcrumbs = $this->getBreadcrumbs($category);

        return view('categories.show', compact('category', 'services', 'subCategories', 'breadcrumbs'));
    }

    /**
     * Get all descendant category IDs recursively.
     * 
     * @param Category $category
     * @return \Illuminate\Support\Collection
     */
    protected function getDescendantIds(Category $category): \Illuminate\Support\Collection
    {
        $ids = collect();

        foreach ($category->children as $child) {
            $ids->push($child->id);
            if ($child->children->isNotEmpty()) {
                $ids = $ids->merge($this->getDescendantIds($child));
            }
        }

        return $ids;
    }

    /**
     * Get breadcrumb trail from root to current category.
     * 
     * @param Category $category
     * @return array
     */
    protected function getBreadcrumbs(Category $category): array
    {
        $breadcrumbs = [];
        $current = $category;

        // Build breadcrumb trail from current to root
        while ($current) {
            array_unshift($breadcrumbs, [
                'title' => $current->title,
                'slug' => $current->slug,
                'url' => route('categories.show', $current->slug),
            ]);

            $current = $current->parent;
        }

        return $breadcrumbs;
    }
}
