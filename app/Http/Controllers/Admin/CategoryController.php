<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $this->authorize('view-forms'); // Reusing form permission for now

        $query = Category::with(['parent', 'children'])
            ->withCount('services');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by parent
        if ($request->filled('parent_id')) {
            if ($request->parent_id === 'null') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent_id);
            }
        }

        // Filter by visibility
        if ($request->filled('visible')) {
            $query->where('visible', $request->visible === '1');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $categories = $query->paginate(20)->withQueryString();

        // Get all parent categories for filter
        $parentCategories = Category::whereNull('parent_id')->orderBy('title')->get();

        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $this->authorize('create-forms');

        $parentCategories = Category::whereNull('parent_id')
            ->orderBy('title')
            ->get();

        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create-forms');

        try {
            $data = $request->validated();
            
            // Get the max order for new category
            if (!isset($data['order'])) {
                $maxOrder = Category::where('parent_id', $data['parent_id'] ?? null)->max('order');
                $data['order'] = ($maxOrder ?? 0) + 1;
            }

            Category::create($data);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $this->authorize('view-forms');

        $category->load(['parent', 'children.services', 'services']);

        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $this->authorize('edit-forms');

        // Get all categories except this one and its descendants
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('title')
            ->get();

        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified category.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('edit-forms');

        try {
            $data = $request->validated();

            // Prevent circular reference
            if (isset($data['parent_id']) && $data['parent_id']) {
                if ($data['parent_id'] == $category->id) {
                    return back()
                        ->withInput()
                        ->with('error', 'A category cannot be its own parent.');
                }

                // Check if the parent is a child of this category
                $parent = Category::find($data['parent_id']);
                if ($parent && $parent->parent_id == $category->id) {
                    return back()
                        ->withInput()
                        ->with('error', 'Cannot create circular reference in category hierarchy.');
                }
            }

            $category->update($data);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete-forms');

        try {
            // Check if category has children
            if ($category->children()->count() > 0) {
                return back()->with('error', 'Cannot delete category with subcategories. Delete or move subcategories first.');
            }

            // Check if category has services
            if ($category->services()->count() > 0) {
                return back()->with('error', 'Cannot delete category with associated services. Remove services first.');
            }

            $category->delete();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
}
