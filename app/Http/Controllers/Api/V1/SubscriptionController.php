<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of subscriptions.
     * 
     * GET /api/v1/subscriptions
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min($request->input('per_page', 15), 100);
        
        $query = Subscription::with(['service', 'customer', 'order']);

        // Filtering
        if ($request->has('status')) {
            $query->whereIn('status', explode(',', $request->status));
        }

        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->has('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->has('auto_renew')) {
            $query->where('auto_renew', filter_var($request->auto_renew, FILTER_VALIDATE_BOOLEAN));
        }

        // Date filtering
        if ($request->has('expires_after')) {
            $query->where('expires_at', '>=', $request->expires_after);
        }

        if ($request->has('expires_before')) {
            $query->where('expires_at', '<=', $request->expires_before);
        }

        if ($request->has('created_after')) {
            $query->where('created_at', '>=', $request->created_after);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('uuid', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('service', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $subscriptions = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => SubscriptionResource::collection($subscriptions),
            'meta' => [
                'current_page' => $subscriptions->currentPage(),
                'last_page' => $subscriptions->lastPage(),
                'per_page' => $subscriptions->perPage(),
                'total' => $subscriptions->total(),
                'from' => $subscriptions->firstItem(),
                'to' => $subscriptions->lastItem(),
            ],
            'links' => [
                'first' => $subscriptions->url(1),
                'last' => $subscriptions->url($subscriptions->lastPage()),
                'prev' => $subscriptions->previousPageUrl(),
                'next' => $subscriptions->nextPageUrl(),
            ],
        ]);
    }

    /**
     * Store a newly created subscription.
     * 
     * POST /api/v1/subscriptions
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => ['required', 'exists:users,id'],
            'service_id' => ['required', 'exists:services,id'],
            'billing_interval' => ['required', 'in:monthly,yearly'],
            'starts_at' => ['required', 'date'],
            'expires_at' => ['required', 'date', 'after:starts_at'],
            'auto_renew' => ['boolean'],
            'trial_ends_at' => ['nullable', 'date'],
            'renewal_price' => ['nullable', 'numeric', 'min:0'],
            'renewal_discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'metadata' => ['nullable', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $subscription = DB::transaction(function () use ($request) {
                $service = Service::findOrFail($request->service_id);
                
                $subscription = Subscription::create([
                    'customer_id' => $request->customer_id,
                    'service_id' => $request->service_id,
                    'billing_interval' => $request->billing_interval,
                    'starts_at' => $request->starts_at,
                    'expires_at' => $request->expires_at,
                    'auto_renew' => $request->input('auto_renew', false),
                    'status' => $request->trial_ends_at ? 'trial' : 'active',
                    'trial_ends_at' => $request->trial_ends_at,
                    'renewal_price' => $request->renewal_price ?? $service->renewal_price ?? $service->price,
                    'renewal_discount_percentage' => $request->renewal_discount_percentage ?? $service->renewal_discount_percentage ?? 0,
                    'metadata' => $request->metadata ?? [],
                ]);

                Log::info('Subscription created via API', [
                    'subscription_id' => $subscription->id,
                    'customer_id' => $subscription->customer_id,
                    'api_user' => auth()->id(),
                ]);

                return $subscription;
            });

            return response()->json([
                'success' => true,
                'message' => 'Subscription created successfully',
                'data' => new SubscriptionResource($subscription->load(['service', 'customer'])),
            ], 201);

        } catch (\Exception $e) {
            Log::error('Failed to create subscription via API', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create subscription',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified subscription.
     * 
     * GET /api/v1/subscriptions/{uuid}
     */
    public function show(string $uuid): JsonResponse
    {
        $subscription = Subscription::with(['service', 'customer', 'order'])
            ->where('uuid', $uuid)
            ->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new SubscriptionResource($subscription),
        ]);
    }

    /**
     * Update the specified subscription.
     * 
     * PUT/PATCH /api/v1/subscriptions/{uuid}
     */
    public function update(Request $request, string $uuid): JsonResponse
    {
        $subscription = Subscription::where('uuid', $uuid)->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => ['in:active,trial,expired,cancelled,suspended,pending_renewal'],
            'expires_at' => ['date'],
            'auto_renew' => ['boolean'],
            'renewal_price' => ['numeric', 'min:0'],
            'renewal_discount_percentage' => ['numeric', 'min:0', 'max:100'],
            'metadata' => ['array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $updated = DB::transaction(function () use ($subscription, $request) {
                $updates = $request->only([
                    'status',
                    'expires_at',
                    'auto_renew',
                    'renewal_price',
                    'renewal_discount_percentage',
                    'metadata',
                ]);

                $subscription->update($updates);

                Log::info('Subscription updated via API', [
                    'subscription_id' => $subscription->id,
                    'updates' => $updates,
                    'api_user' => auth()->id(),
                ]);

                return $subscription;
            });

            return response()->json([
                'success' => true,
                'message' => 'Subscription updated successfully',
                'data' => new SubscriptionResource($updated->load(['service', 'customer'])),
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update subscription via API', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update subscription',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cancel the specified subscription.
     * 
     * DELETE /api/v1/subscriptions/{uuid}
     */
    public function destroy(string $uuid): JsonResponse
    {
        $subscription = Subscription::where('uuid', $uuid)->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        try {
            DB::transaction(function () use ($subscription) {
                $subscription->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                    'auto_renew' => false,
                ]);

                Log::info('Subscription cancelled via API', [
                    'subscription_id' => $subscription->id,
                    'api_user' => auth()->id(),
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Subscription cancelled successfully',
                'data' => new SubscriptionResource($subscription->load(['service', 'customer'])),
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to cancel subscription via API', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel subscription',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Renew the specified subscription.
     * 
     * POST /api/v1/subscriptions/{uuid}/renew
     */
    public function renew(Request $request, string $uuid): JsonResponse
    {
        $subscription = Subscription::where('uuid', $uuid)->first();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription not found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'duration_months' => ['integer', 'min:1', 'max:36'],
            'payment_method' => ['string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $renewed = DB::transaction(function () use ($subscription, $request) {
                $service = $subscription->service;
                $durationMonths = $request->input('duration_months', 
                    $subscription->billing_interval === 'yearly' ? 12 : 1
                );

                // Calculate new expiration date
                $newExpiresAt = $subscription->expires_at > now() 
                    ? $subscription->expires_at->addMonths($durationMonths)
                    : now()->addMonths($durationMonths);

                $subscription->update([
                    'expires_at' => $newExpiresAt,
                    'status' => 'active',
                    'cancelled_at' => null,
                ]);

                Log::info('Subscription renewed via API', [
                    'subscription_id' => $subscription->id,
                    'new_expires_at' => $newExpiresAt,
                    'duration_months' => $durationMonths,
                    'api_user' => auth()->id(),
                ]);

                return $subscription;
            });

            return response()->json([
                'success' => true,
                'message' => 'Subscription renewed successfully',
                'data' => new SubscriptionResource($renewed->load(['service', 'customer'])),
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to renew subscription via API', [
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to renew subscription',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get subscription statistics.
     * 
     * GET /api/v1/subscriptions/stats
     */
    public function stats(): JsonResponse
    {
        try {
            $stats = [
                'total' => Subscription::count(),
                'active' => Subscription::where('status', 'active')->count(),
                'trial' => Subscription::where('status', 'trial')->count(),
                'expired' => Subscription::where('status', 'expired')->count(),
                'cancelled' => Subscription::where('status', 'cancelled')->count(),
                'suspended' => Subscription::where('status', 'suspended')->count(),
                'pending_renewal' => Subscription::where('status', 'pending_renewal')->count(),
                'expiring_soon' => Subscription::where('status', 'active')
                    ->where('expires_at', '<=', now()->addDays(30))
                    ->where('expires_at', '>', now())
                    ->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
