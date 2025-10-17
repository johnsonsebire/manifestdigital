<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the customer's orders.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->orders()
            ->with(['items.service', 'payments', 'project'])
            ->withCount('items');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(10)->withQueryString();

        // Statistics
        $stats = [
            'total' => auth()->user()->orders()->count(),
            'pending' => auth()->user()->orders()->whereIn('status', ['pending', 'initiated'])->count(),
            'active' => auth()->user()->orders()->whereIn('status', ['paid', 'processing'])->count(),
            'completed' => auth()->user()->orders()->where('status', 'completed')->count(),
        ];

        return view('customer.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Ensure user owns this order
        $this->authorize('view', $order);

        $order->load([
            'items.service.categories',
            'items.variant',
            'payments',
            'project.tasks',
        ]);

        // Get activity logs from related project if it exists
        $activities = collect();
        if ($order->project) {
            $activities = ActivityLog::where('project_id', $order->project->id)
                ->with('user')
                ->latest()
                ->get();
        }

        return view('customer.orders.show', compact('order', 'activities'));
    }
}
