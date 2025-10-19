<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Service;
use App\Models\ServiceVariant;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

        $query = Order::with(['customer', 'items.service', 'project'])
            ->withCount('items');

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status')) {
            $query->paymentStatus($request->payment_status);
        }

        // Customer filter
        if ($request->filled('customer_id')) {
            $query->forCustomer($request->customer_id);
        }

        // Date range filter
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->dateRange($request->date_from, $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(15)->withQueryString();

        // Get customers for filter dropdown
        $customers = User::role('Customer')->orderBy('name')->get();

        // Statistics for dashboard
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'approved' => Order::where('status', 'approved')->count(),
            'paid' => Order::where('status', 'paid')->count(),
            'in_progress' => Order::where('status', 'in_progress')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total'),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'customers'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $this->authorize('manage-orders');

        // Get customers for dropdown
        $customers = User::role('Customer')->orderBy('name')->get();

        // Get available services with variants
        $services = Service::with('variants')
            ->where('available', true)
            ->orderBy('title')
            ->get();

        return view('admin.orders.create', compact('customers', 'services'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $this->authorize('manage-orders');

        $validated = $request->validate([
            'customer_id' => 'required|exists:users,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'status' => 'required|in:pending,initiated,paid,processing,completed,cancelled,refunded',
            'payment_status' => 'required|in:unpaid,pending,paid,partial,refunded',
            'payment_method' => 'nullable|string|in:paystack,stripe,paypal,bank_transfer',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.variant_id' => 'nullable|exists:service_variants,id',
            'items.*.quantity' => 'required|integer|min:1|max:100',
            'items.*.unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:2000',
        ]);

        try {
            DB::beginTransaction();

            // Get customer information
            $customer = User::findOrFail($validated['customer_id']);

            // Create order
            $order = Order::create([
                'uuid' => Str::uuid(),
                'customer_id' => $customer->id,
                'customer_name' => $validated['customer_name'] ?: $customer->name,
                'customer_email' => $validated['customer_email'] ?: $customer->email,
                'customer_phone' => $validated['customer_phone'] ?: $customer->phone,
                'customer_address' => $validated['customer_address'] ?: $customer->address,
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'payment_method' => $validated['payment_method'],
                'subtotal' => 0, // Will be calculated
                'discount' => $validated['discount'] ?? 0,
                'tax' => $validated['tax'] ?? 0,
                'total' => 0, // Will be calculated
                'notes' => $validated['notes'],
                'metadata' => [
                    'created_by_staff' => auth()->id(),
                    'created_by_staff_name' => auth()->user()->name,
                    'creation_ip' => $request->ip(),
                ],
                'placed_at' => now(),
            ]);

            // Create order items and calculate subtotal
            $subtotal = 0;
            foreach ($validated['items'] as $item) {
                $service = Service::findOrFail($item['service_id']);
                
                // Get variant name if variant is specified
                $variantName = null;
                if (!empty($item['variant_id'])) {
                    $variant = ServiceVariant::findOrFail($item['variant_id']);
                    // Ensure variant belongs to the service
                    if ($variant->service_id !== $service->id) {
                        throw new \Exception("Variant does not belong to the selected service.");
                    }
                    $variantName = $variant->name;
                }

                $lineTotal = $item['unit_price'] * $item['quantity'];
                $subtotal += $lineTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'title' => $service->title,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'line_total' => $lineTotal,
                    'metadata' => [
                        'variant_name' => $variantName,
                        'type' => $service->type,
                        'created_by_staff' => auth()->id(),
                    ],
                ]);
            }

            // Update order totals
            $total = $subtotal - $order->discount + $order->tax;
            $order->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            // Log activity
            activity()
                ->performedOn($order)
                ->causedBy(auth()->user())
                ->withProperties([
                    'order_total' => $total,
                    'items_count' => count($validated['items']),
                    'customer_name' => $customer->name,
                ])
                ->log('Order created by staff');

            DB::commit();

            return redirect()
                ->route('admin.orders.show', $order)
                ->with('success', 'Order created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified order with full details.
     */
    public function show(Order $order)
    {
        $this->authorize('view-orders');

        $order->load([
            'customer',
            'items.service.categories',
            'items.variant',
            'payments',
            'project.team',
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
                'amount' => $order->total,
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
