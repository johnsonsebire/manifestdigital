<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderChangeRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderChangeRequestController extends Controller
{
    /**
     * Display a listing of change requests.
     */
    public function index(Request $request)
    {
        $query = OrderChangeRequest::with(['order.customer', 'requester', 'reviewer'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $changeRequests = $query->paginate(20);

        return view('admin.change-requests.index', compact('changeRequests'));
    }

    /**
     * Display the specified change request.
     */
    public function show(OrderChangeRequest $changeRequest)
    {
        $changeRequest->load(['order.items.service', 'order.customer', 'requester', 'reviewer']);

        return view('admin.change-requests.show', compact('changeRequest'));
    }

    /**
     * Approve the change request.
     */
    public function approve(Request $request, OrderChangeRequest $changeRequest)
    {
        if (!$changeRequest->isPending()) {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        $request->validate([
            'review_notes' => 'nullable|string|max:1000',
        ]);

        $changeRequest->approve(auth()->user(), $request->review_notes);

        // Log activity to project if exists
        if ($changeRequest->order->project) {
            \App\Models\ActivityLog::create([
                'project_id' => $changeRequest->order->project->id,
                'user_id' => auth()->id(),
                'type' => 'change_approved',
                'description' => 'Change request #' . $changeRequest->id . ' approved by ' . auth()->user()->name,
            ]);
        }

        return redirect()
            ->route('admin.change-requests.show', $changeRequest)
            ->with('success', 'Change request approved successfully. Customer can now proceed with payment.');
    }

    /**
     * Reject the change request.
     */
    public function reject(Request $request, OrderChangeRequest $changeRequest)
    {
        if (!$changeRequest->isPending()) {
            return back()->with('error', 'Only pending requests can be rejected.');
        }

        $request->validate([
            'review_notes' => 'required|string|max:1000',
        ]);

        $changeRequest->reject(auth()->user(), $request->review_notes);

        // Log activity to project if exists
        if ($changeRequest->order->project) {
            \App\Models\ActivityLog::create([
                'project_id' => $changeRequest->order->project->id,
                'user_id' => auth()->id(),
                'type' => 'change_rejected',
                'description' => 'Change request #' . $changeRequest->id . ' rejected by ' . auth()->user()->name,
            ]);
        }

        return redirect()
            ->route('admin.change-requests.show', $changeRequest)
            ->with('success', 'Change request rejected.');
    }

    /**
     * Apply the approved change to the order.
     */
    public function apply(OrderChangeRequest $changeRequest)
    {
        if (!$changeRequest->isApproved()) {
            return back()->with('error', 'Only approved requests can be applied.');
        }

        if ($changeRequest->status === 'applied') {
            return back()->with('error', 'This change has already been applied.');
        }

        $order = $changeRequest->order;
        $newSnapshot = $changeRequest->new_snapshot;

        // Process the changes based on the snapshot
        foreach ($newSnapshot['changes_requested'] as $change) {
            if ($change['action'] === 'add') {
                $service = Service::find($change['service_id']);
                $quantity = $change['quantity'] ?? 1;
                
                $order->items()->create([
                    'service_id' => $service->id,
                    'quantity' => $quantity,
                    'unit_price' => $service->price,
                    'subtotal' => $service->price * $quantity,
                ]);
            } elseif ($change['action'] === 'remove') {
                $order->items()->where('id', $change['item_id'])->delete();
            } elseif ($change['action'] === 'modify') {
                $item = $order->items()->find($change['item_id']);
                if ($item) {
                    $newQuantity = $change['quantity'] ?? $item->quantity;
                    $item->update([
                        'quantity' => $newQuantity,
                        'subtotal' => $item->unit_price * $newQuantity,
                    ]);
                }
            }
        }

        // Update order total
        $order->update([
            'total' => $changeRequest->proposed_amount,
        ]);

        // Mark change request as applied
        $changeRequest->update(['status' => 'applied']);

        // Log activity to project if exists
        if ($order->project) {
            \App\Models\ActivityLog::create([
                'project_id' => $order->project->id,
                'user_id' => auth()->id(),
                'type' => 'change_applied',
                'description' => 'Change request #' . $changeRequest->id . ' applied to order by ' . auth()->user()->name,
            ]);
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'Changes applied to order successfully.');
    }
}
