<?php

namespace App\Services;

use App\Events\OrderApproved;
use App\Models\ActivityLog;
use App\Models\Order;
use App\Notifications\OrderStatusChanged;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    /**
     * Valid order status transitions.
     */
    protected array $validTransitions = [
        'pending' => ['initiated', 'cancelled'],
        'initiated' => ['paid', 'cancelled'],
        'paid' => ['processing', 'refunded'],
        'processing' => ['completed', 'cancelled'],
        'completed' => [],
        'cancelled' => [],
        'refunded' => [],
    ];

    /**
     * Transition order to a new status.
     */
    public function transitionStatus(Order $order, string $newStatus, ?string $reason = null, ?int $userId = null): bool
    {
        $currentStatus = $order->status;

        // Validate transition
        if (!$this->canTransition($currentStatus, $newStatus)) {
            Log::warning('Invalid order status transition', [
                'order_id' => $order->id,
                'from' => $currentStatus,
                'to' => $newStatus,
            ]);
            return false;
        }

        try {
            DB::beginTransaction();

            $oldStatus = $order->status;
            $order->update(['status' => $newStatus]);

            // Log the transition to project activity logs if project exists
            if ($order->project_id) {
                ActivityLog::create([
                    'project_id' => $order->project_id,
                    'user_id' => $userId ?? auth()->id(),
                    'type' => 'order_status_changed',
                    'description' => "Order status changed from {$oldStatus} to {$newStatus}",
                    'meta' => [
                        'order_id' => $order->id,
                        'old_status' => $oldStatus,
                        'new_status' => $newStatus,
                        'reason' => $reason,
                    ],
                ]);
            }

            // Fire events based on new status
            $this->fireStatusEvent($order, $newStatus);

            // Send notification to customer about status change
            if ($order->customer) {
                $order->customer->notify(new OrderStatusChanged($order, $oldStatus, $newStatus));
            }

            DB::commit();

            Log::info('Order status transitioned', [
                'order_id' => $order->id,
                'from' => $oldStatus,
                'to' => $newStatus,
            ]);

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order status transition failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Check if transition is valid.
     */
    public function canTransition(string $currentStatus, string $newStatus): bool
    {
        return in_array($newStatus, $this->validTransitions[$currentStatus] ?? []);
    }

    /**
     * Get available transitions for current status.
     */
    public function getAvailableTransitions(Order $order): array
    {
        return $this->validTransitions[$order->status] ?? [];
    }

    /**
     * Mark order as paid (called after successful payment).
     */
    public function markAsPaid(Order $order): bool
    {
        if ($order->payment_status === 'paid') {
            return true; // Already paid
        }

        try {
            DB::beginTransaction();

            $order->update([
                'payment_status' => 'paid',
                'status' => $order->status === 'pending' ? 'initiated' : $order->status,
            ]);

            // Log payment to project activity logs if project exists
            if ($order->project_id) {
                ActivityLog::create([
                    'project_id' => $order->project_id,
                    'user_id' => $order->customer_id,
                    'type' => 'order_paid',
                    'description' => "Order #{$order->uuid} marked as paid",
                    'meta' => [
                        'order_id' => $order->id,
                        'payment_amount' => $order->total,
                        'payment_method' => $order->payment_method,
                    ],
                ]);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to mark order as paid', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Approve an order (staff action).
     */
    public function approveOrder(Order $order, ?int $userId = null): bool
    {
        // Check if order can be approved
        if (!in_array($order->status, ['paid', 'initiated'])) {
            Log::warning('Order cannot be approved in current status', [
                'order_id' => $order->id,
                'status' => $order->status,
            ]);
            return false;
        }

        try {
            DB::beginTransaction();

            // Transition to processing
            $order->update([
                'status' => 'processing',
                'metadata' => array_merge($order->metadata ?? [], [
                    'approved_at' => now()->toIso8601String(),
                    'approved_by' => $userId ?? auth()->id(),
                ]),
            ]);

            // Log approval to project activity logs if project exists
            if ($order->project_id) {
                ActivityLog::create([
                    'project_id' => $order->project_id,
                    'user_id' => $userId ?? auth()->id(),
                    'type' => 'order_approved',
                    'description' => "Order #{$order->uuid} approved and moved to processing",
                    'meta' => [
                        'order_id' => $order->id,
                        'previous_status' => 'paid',
                        'new_status' => 'processing',
                    ],
                ]);
            }

            // Fire OrderApproved event
            event(new OrderApproved($order));

            // Auto-create project for approved orders
            $projectService = app(\App\Services\ProjectService::class);
            $projectService->createFromOrder($order, $userId);

            DB::commit();

            Log::info('Order approved', [
                'order_id' => $order->id,
                'approved_by' => $userId ?? auth()->id(),
            ]);

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order approval failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Cancel an order.
     */
    public function cancelOrder(Order $order, string $reason, ?int $userId = null): bool
    {
        if (!$this->canTransition($order->status, 'cancelled')) {
            return false;
        }

        try {
            DB::beginTransaction();

            $order->update([
                'status' => 'cancelled',
                'metadata' => array_merge($order->metadata ?? [], [
                    'cancelled_at' => now()->toIso8601String(),
                    'cancelled_by' => $userId ?? auth()->id(),
                    'cancellation_reason' => $reason,
                ]),
            ]);

            // Log cancellation to project activity logs if project exists
            if ($order->project_id) {
                ActivityLog::create([
                    'project_id' => $order->project_id,
                    'user_id' => $userId ?? auth()->id(),
                    'type' => 'order_cancelled',
                    'description' => "Order #{$order->uuid} cancelled: {$reason}",
                    'meta' => [
                        'order_id' => $order->id,
                        'reason' => $reason,
                    ],
                ]);
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order cancellation failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Complete an order.
     */
    public function completeOrder(Order $order, ?int $userId = null): bool
    {
        if (!$this->canTransition($order->status, 'completed')) {
            return false;
        }

        return $this->transitionStatus($order, 'completed', 'Order completed', $userId);
    }

    /**
     * Fire appropriate events based on status.
     */
    protected function fireStatusEvent(Order $order, string $status): void
    {
        // Additional events can be fired here based on status
        // For now, specific events are fired in their respective methods
    }

    /**
     * Get order status badge color.
     */
    public function getStatusBadgeColor(string $status): string
    {
        return match($status) {
            'pending' => 'yellow',
            'initiated' => 'blue',
            'paid' => 'green',
            'processing' => 'indigo',
            'completed' => 'green',
            'cancelled' => 'red',
            'refunded' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Get order statistics.
     */
    public function getOrderStatistics(?int $customerId = null): array
    {
        $query = Order::query();

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        return [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'processing' => (clone $query)->where('status', 'processing')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
            'total_revenue' => (clone $query)->where('payment_status', 'paid')->sum('total'),
        ];
    }
}
