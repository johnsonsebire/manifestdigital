<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Project;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of orders with filtering.
     */
    public function index(Request $request)
    {
        $this->authorize('view-orders');

        $query = Order::with(['user', 'items.service', 'project'])
            ->withCount('items');

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(15)->withQueryString();

        // Statistics for dashboard
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'completed' => Order::where('status', 'completed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display the specified order with full details.
     */
    public function show(Order $order)
    {
        $this->authorize('view-orders');

        $order->load([
            'user',
            'items.service.category',
            'items.variant',
            'payments',
            'project.team',
            'project.tasks',
        ]);

        // Get activity logs for this order
        $activities = ActivityLog::where('loggable_type', Order::class)
            ->where('loggable_id', $order->id)
            ->with('user')
            ->latest()
            ->get();

        // Get related project activities if project exists
        if ($order->project) {
            $projectActivities = ActivityLog::where('loggable_type', Project::class)
                ->where('loggable_id', $order->project->id)
                ->with('user')
                ->latest()
                ->get();
            
            $activities = $activities->merge($projectActivities)->sortByDesc('created_at');
        }

        return view('admin.orders.show', compact('order', 'activities'));
    }

    /**
     * Approve an order (transitions to processing and creates project).
     */
    public function approve(Order $order)
    {
        $this->authorize('manage-orders');

        if ($order->status !== 'paid') {
            return back()->with('error', 'Only paid orders can be approved.');
        }

        try {
            $this->orderService->approveOrder($order, auth()->id());

            return back()->with('success', 'Order approved successfully. Project has been created.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve order: ' . $e->getMessage());
        }
    }

    /**
     * Reject/cancel an order.
     */
    public function reject(Request $request, Order $order)
    {
        $this->authorize('manage-orders');

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        try {
            $this->orderService->cancelOrder($order, $request->reason, auth()->id());

            return back()->with('success', 'Order has been cancelled.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    /**
     * Mark order as completed.
     */
    public function complete(Order $order)
    {
        $this->authorize('manage-orders');

        if ($order->status !== 'processing') {
            return back()->with('error', 'Only processing orders can be marked as completed.');
        }

        try {
            $this->orderService->completeOrder($order, auth()->id());

            return back()->with('success', 'Order marked as completed.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to complete order: ' . $e->getMessage());
        }
    }

    /**
     * Manually mark order as paid (for bank transfers).
     */
    public function markAsPaid(Request $request, Order $order)
    {
        $this->authorize('manage-orders');

        $request->validate([
            'reference' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($order->status !== 'initiated') {
            return back()->with('error', 'Only initiated orders can be marked as paid.');
        }

        try {
            DB::beginTransaction();

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'gateway' => 'bank_transfer',
                'amount' => $order->total_amount,
                'currency' => 'NGN',
                'status' => 'successful',
                'reference' => $request->reference,
                'metadata' => [
                    'verified_by' => auth()->id(),
                    'notes' => $request->notes,
                    'verified_at' => now()->toIso8601String(),
                ],
            ]);

            // Mark order as paid
            $this->orderService->markAsPaid($order, auth()->id());

            DB::commit();

            return back()->with('success', 'Order marked as paid successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to mark order as paid: ' . $e->getMessage());
        }
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('manage-orders');

        $request->validate([
            'status' => 'required|string|in:pending,initiated,paid,processing,completed,cancelled,refunded',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $this->orderService->transitionStatus(
                $order,
                $request->status,
                $request->reason,
                auth()->id()
            );

            return back()->with('success', 'Order status updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update order status: ' . $e->getMessage());
        }
    }
}
