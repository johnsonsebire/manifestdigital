<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    /**
     * Display a listing of services (public catalog).
     * 
     * GET /services
     * 
     * Supports filtering by:
     * - category (slug)
     * - type (package, subscription, custom, one_time, ai_enhanced, consulting, add_on)
     * - search (title, description)
     * - sort (price_asc, price_desc, newest, popular)
     */
    public function index(Request $request)
    {
        $query = Service::with(['categories', 'variants'])
            ->where('visible', true) // Only show visible services in public listing
            ->where('available', true);

        // Filter by category
        if ($request->has('category')) {
            $categorySlug = $request->get('category');
            $query->whereHas('categories', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)
                    ->where('visible', true);
            });
        }

        // Filter by service type
        if ($request->has('type')) {
            $types = is_array($request->get('type')) 
                ? $request->get('type') 
                : [$request->get('type')];
            $query->whereIn('type', $types);
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_asc':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('base_price', 'desc');
                break;
            case 'popular':
                // Order by number of times ordered (via order_items count)
                $query->withCount('orderItems')
                    ->orderBy('order_items_count', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $services = $query->paginate(12);

        // Get all visible categories for filter sidebar
        $categories = Cache::remember('visible_categories', 3600, function () {
            return Category::visible()
                ->withCount(['services' => function ($q) {
                    $q->where('visible', true)->where('available', true);
                }])
                ->orderBy('order')
                ->get();
        });

        return view('services.index', compact('services', 'categories'));
    }

    /**
     * Display the specified service (product detail page).
     * 
     * GET /services/{slug}
     * 
     * This is the main product page where users learn about the service
     * and can initiate an order. Supports access to unlisted but available services.
     */
    public function show(string $slug)
    {
        // Find service by slug
        // Allow unlisted services to be accessed directly by URL
        $service = Service::with(['categories', 'variants'])
            ->where('slug', $slug)
            ->where('available', true)
            ->firstOrFail();

        // Authorization: Public can view visible services
        // For unlisted services, anyone with the link can view (useful for private offerings)
        if (!$service->visible) {
            // Check if user is authenticated staff/admin (they can always see)
            if (auth()->guest() || !auth()->user()->hasAnyRole(['Staff', 'Administrator', 'Super Admin'])) {
                // For guests and customers, only allow if service is available (unlisted but accessible)
                // The fact that we're here means available=true, so allow access
                // This enables "unlisted" products that are shared via direct link
            }
        }

        // Get related services from same categories
        $relatedServices = Service::with(['categories', 'variants'])
            ->where('visible', true)
            ->where('available', true)
            ->where('id', '!=', $service->id)
            ->whereHas('categories', function ($q) use ($service) {
                $q->whereIn('categories.id', $service->categories->pluck('id'));
            })
            ->limit(4)
            ->get();

        return view('services.show', compact('service', 'relatedServices'));
    }

    /**
     * Get service price (AJAX endpoint for dynamic pricing).
     * 
     * POST /services/{slug}/price
     * 
     * Used by frontend to fetch current price including variant pricing.
     * Always returns server-side calculated price - never trust client.
     */
    public function getPrice(Request $request, string $slug)
    {
        $service = Service::where('slug', $slug)
            ->where('available', true)
            ->firstOrFail();

        $price = $service->sale_price ?? $service->base_price;
        $variantPrice = null;

        // If variant_id provided, get variant price
        if ($request->filled('variant_id')) {
            $variant = $service->variants()
                ->where('id', $request->get('variant_id'))
                ->where('is_available', true)
                ->first();

            if ($variant) {
                $variantPrice = $variant->sale_price ?? $variant->price;
                $price = $variantPrice; // Use variant price if available
            }
        }

        return response()->json([
            'service_id' => $service->id,
            'base_price' => (float) $service->base_price,
            'sale_price' => $service->sale_price ? (float) $service->sale_price : null,
            'current_price' => (float) $price,
            'variant_price' => $variantPrice ? (float) $variantPrice : null,
            'currency' => 'USD', // TODO: Make configurable
        ]);
    }
}
