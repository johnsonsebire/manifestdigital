<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceManagementController extends Controller
{
    /**
     * Display a listing of services.
     */
    public function index(Request $request)
    {
        $this->authorize('view-forms');

        $query = Service::with(['categories', 'variants'])
            ->withCount('variants');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by availability
        if ($request->filled('available')) {
            $query->where('available', $request->available === '1');
        }

        // Filter by visibility
        if ($request->filled('visible')) {
            $query->where('visible', $request->visible === '1');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $services = $query->paginate(20)->withQueryString();

        // Get categories for filter
        $categories = Category::orderBy('title')->get();

        return view('admin.services.index', compact('services', 'categories'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function create()
    {
        $this->authorize('create-forms');

        $categories = Category::orderBy('title')->get();

        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created service.
     */
    public function store(StoreServiceRequest $request)
    {
        $this->authorize('create-forms');

        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['created_by'] = auth()->id();

            // Handle category IDs separately
            $categoryIds = $data['category_ids'] ?? [];
            unset($data['category_ids']);

            $service = Service::create($data);

            // Attach categories
            if (!empty($categoryIds)) {
                $service->categories()->attach($categoryIds);
            }

            DB::commit();

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create service: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service)
    {
        $this->authorize('view-forms');

        $service->load(['categories', 'variants', 'creator']);

        return view('admin.services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service)
    {
        $this->authorize('edit-forms');

        $categories = Category::orderBy('title')->get();
        $service->load('categories');

        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified service.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->authorize('edit-forms');

        try {
            DB::beginTransaction();

            $data = $request->validated();

            // Handle category IDs separately
            $categoryIds = $data['category_ids'] ?? [];
            unset($data['category_ids']);

            $service->update($data);

            // Sync categories
            $service->categories()->sync($categoryIds);

            DB::commit();

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified service.
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete-forms');

        try {
            // Check if service has orders
            if ($service->orderItems()->count() > 0) {
                return back()->with('error', 'Cannot delete service with existing orders.');
            }

            $service->delete();

            return redirect()
                ->route('admin.services.index')
                ->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete service: ' . $e->getMessage());
        }
    }
}
