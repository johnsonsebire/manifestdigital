<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderChangeRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderChangeRequestController extends Controller
{
    /**
     * Show the form for creating a new change request.
     */
    public function create(Order $order)
    {
        // Ensure customer owns this order
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized to modify this order.');
        }

        // Only allow changes for approved orders
        if ($order->status !== 'approved') {
            return back()->with('error', 'Changes can only be requested for approved orders.');
        }

        // Get available services for upgrades
        $services = Service::where('is_active', true)->get();
        
        return view('customer.orders.change-request', compact('order', 'services'));
    }

    /**
     * Store a newly created change request.
     */
    public function store(Request $request, Order $order)
    {
        // Ensure customer owns this order
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized to modify this order.');
        }

        // Only allow changes for approved orders
        if ($order->status !== 'approved') {
            return back()->with('error', 'Changes can only be requested for approved orders.');
        }

        $request->validate([
            'type' => 'required|in:upgrade,downgrade,custom_change',
            'changes' => 'required|array',
            'changes.*.action' => 'required|in:add,remove,modify',
            'changes.*.service_id' => 'required_if:changes.*.action,add|exists:services,id',
            'changes.*.item_id' => 'required_unless:changes.*.action,add|exists:order_items,id',
            'changes.*.quantity' => 'nullable|integer|min:1',
            'reason' => 'required|string|max:1000',
        ]);

        // Create snapshot of current order
        $oldSnapshot = [
            'items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'service_id' => $item->service_id,
                    'service_title' => $item->service->title,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'subtotal' => $item->subtotal,
                ];
            })->toArray(),
            'total_amount' => $order->total_amount,
        ];

        // Calculate new snapshot and proposed amount
        $newItems = collect($oldSnapshot['items']);
        $proposedAmount = $order->total_amount;

        foreach ($request->changes as $change) {
            if ($change['action'] === 'add') {
                $service = Service::find($change['service_id']);
                $quantity = $change['quantity'] ?? 1;
                $subtotal = $service->price * $quantity;
                
                $newItems->push([
                    'service_id' => $service->id,
                    'service_title' => $service->title,
                    'quantity' => $quantity,
                    'unit_price' => $service->price,
                    'subtotal' => $subtotal,
                ]);
                
                $proposedAmount += $subtotal;
            } elseif ($change['action'] === 'remove') {
                $item = $newItems->firstWhere('id', $change['item_id']);
                if ($item) {
                    $proposedAmount -= $item['subtotal'];
                    $newItems = $newItems->reject(fn($i) => $i['id'] === $change['item_id']);
                }
            } elseif ($change['action'] === 'modify') {
                $index = $newItems->search(fn($i) => $i['id'] === $change['item_id']);
                if ($index !== false) {
                    $item = $newItems[$index];
                    $newQuantity = $change['quantity'] ?? $item['quantity'];
                    $oldSubtotal = $item['subtotal'];
                    $newSubtotal = $item['unit_price'] * $newQuantity;
                    
                    $proposedAmount = $proposedAmount - $oldSubtotal + $newSubtotal;
                    
                    $newItems[$index]['quantity'] = $newQuantity;
                    $newItems[$index]['subtotal'] = $newSubtotal;
                }
            }
        }

        $newSnapshot = [
            'items' => $newItems->values()->toArray(),
            'total_amount' => $proposedAmount,
            'reason' => $request->reason,
            'changes_requested' => $request->changes,
        ];

        // Create change request
        $changeRequest = $order->changeRequests()->create([
            'requested_by' => auth()->id(),
            'type' => $request->type,
            'old_snapshot' => $oldSnapshot,
            'new_snapshot' => $newSnapshot,
            'proposed_amount' => $proposedAmount,
            'status' => 'pending',
        ]);

        // Log activity
        $order->activities()->create([
            'user_id' => auth()->id(),
            'action' => 'change_requested',
            'description' => 'Customer requested a change to order (Type: ' . ucfirst($request->type) . ')',
        ]);

        return redirect()
            ->route('customer.orders.show', $order)
            ->with('success', 'Change request submitted successfully. Our team will review it shortly.');
    }

    /**
     * Display the specified change request.
     */
    public function show(Order $order, OrderChangeRequest $changeRequest)
    {
        // Ensure customer owns this order
        if ($order->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized to view this change request.');
        }

        return view('customer.orders.change-request-show', compact('order', 'changeRequest'));
    }
}
