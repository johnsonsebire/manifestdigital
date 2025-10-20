<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceExpirationReminder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReminderConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrator|Super Admin|Staff']);
    }

    /**
     * Display reminder configuration dashboard.
     * 
     * GET /admin/reminders
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status'); // active, inactive, all
        $type = $request->input('type'); // service, customer, all

        // Get service-level reminders
        $serviceReminders = ServiceExpirationReminder::with('service')
            ->serviceDefaults()
            ->when($search, function ($query, $search) {
                $query->whereHas('service', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', fn($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn($q) => $q->where('is_active', false))
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'service_page');

        // Get customer-specific reminders
        $customerReminders = ServiceExpirationReminder::with(['service', 'customer'])
            ->customerSpecific()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('service', function ($sq) use ($search) {
                        $sq->where('title', 'like', "%{$search}%");
                    })->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
                    });
                });
            })
            ->when($status === 'active', fn($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn($q) => $q->where('is_active', false))
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'customer_page');

        // Statistics
        $stats = [
            'total_service_reminders' => ServiceExpirationReminder::serviceDefaults()->count(),
            'active_service_reminders' => ServiceExpirationReminder::serviceDefaults()->active()->count(),
            'total_customer_reminders' => ServiceExpirationReminder::customerSpecific()->count(),
            'active_customer_reminders' => ServiceExpirationReminder::customerSpecific()->active()->count(),
            'services_with_reminders' => ServiceExpirationReminder::serviceDefaults()->distinct('service_id')->count(),
            'services_without_reminders' => Service::whereDoesntHave('expirationReminders', function ($q) {
                $q->whereNull('customer_id');
            })->where('is_subscription', true)->count(),
        ];

        return view('admin.reminders.index', [
            'serviceReminders' => $type === 'customer' ? collect() : $serviceReminders,
            'customerReminders' => $type === 'service' ? collect() : $customerReminders,
            'stats' => $stats,
            'search' => $search,
            'status' => $status,
            'type' => $type,
        ]);
    }

    /**
     * Display form to configure service-level reminders.
     * 
     * GET /admin/reminders/service/{service}
     */
    public function configureService(Service $service)
    {
        $reminder = ServiceExpirationReminder::where('service_id', $service->id)
            ->whereNull('customer_id')
            ->first();

        // Get list of customers who have subscriptions for this service
        $customers = User::whereHas('subscriptions', function ($q) use ($service) {
            $q->where('service_id', $service->id);
        })->select('id', 'name', 'email')->get();

        // Get customer-specific overrides for this service
        $customerOverrides = ServiceExpirationReminder::with('customer')
            ->where('service_id', $service->id)
            ->whereNotNull('customer_id')
            ->get();

        return view('admin.reminders.configure-service', [
            'service' => $service,
            'reminder' => $reminder,
            'customers' => $customers,
            'customerOverrides' => $customerOverrides,
        ]);
    }

    /**
     * Save or update service-level reminder configuration.
     * 
     * POST /admin/reminders/service/{service}
     */
    public function storeServiceConfig(Service $service, Request $request)
    {
        $validated = $request->validate([
            'reminder_days_before' => ['required', 'array', 'min:1'],
            'reminder_days_before.*' => ['required', 'integer', 'min:0', 'max:90'],
            'email_template' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'custom_message' => ['nullable', 'string', 'max:1000'],
        ]);

        // Remove duplicates and sort
        $reminderDays = array_values(array_unique($validated['reminder_days_before']));
        rsort($reminderDays); // Sort descending (15, 10, 5, 1, 0)

        try {
            $reminder = ServiceExpirationReminder::updateOrCreate(
                [
                    'service_id' => $service->id,
                    'customer_id' => null,
                ],
                [
                    'reminder_days_before' => $reminderDays,
                    'email_template' => $validated['email_template'] ?? null,
                    'is_active' => $request->has('is_active'),
                    'custom_message' => $validated['custom_message'] ?? null,
                    'metadata' => [
                        'updated_by' => auth()->id(),
                        'updated_at' => now()->toISOString(),
                    ],
                ]
            );

            Log::info('Service reminder configuration updated', [
                'service_id' => $service->id,
                'reminder_id' => $reminder->id,
                'days' => $reminderDays,
                'active' => $reminder->is_active,
            ]);

            return redirect()->back()
                ->with('success', 'Service reminder configuration saved successfully.');

        } catch (\Exception $e) {
            Log::error('Failed to save service reminder configuration', [
                'service_id' => $service->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save configuration. Please try again.');
        }
    }

    /**
     * Display form to configure customer-specific reminder.
     * 
     * GET /admin/reminders/customer/{service}/{customer}
     */
    public function configureCustomer(Service $service, User $customer)
    {
        // Get service default for reference
        $serviceDefault = ServiceExpirationReminder::where('service_id', $service->id)
            ->whereNull('customer_id')
            ->first();

        // Get or create customer-specific reminder
        $reminder = ServiceExpirationReminder::where('service_id', $service->id)
            ->where('customer_id', $customer->id)
            ->first();

        // Check if customer has subscriptions for this service
        $hasSubscription = $customer->subscriptions()
            ->where('service_id', $service->id)
            ->exists();

        return view('admin.reminders.configure-customer', [
            'service' => $service,
            'customer' => $customer,
            'reminder' => $reminder,
            'serviceDefault' => $serviceDefault,
            'hasSubscription' => $hasSubscription,
        ]);
    }

    /**
     * Save or update customer-specific reminder configuration.
     * 
     * POST /admin/reminders/customer/{service}/{customer}
     */
    public function storeCustomerConfig(Service $service, User $customer, Request $request)
    {
        $validated = $request->validate([
            'reminder_days_before' => ['required', 'array', 'min:1'],
            'reminder_days_before.*' => ['required', 'integer', 'min:0', 'max:90'],
            'email_template' => ['nullable', 'string', 'max:255'],
            'is_active' => ['boolean'],
            'custom_message' => ['nullable', 'string', 'max:1000'],
        ]);

        // Remove duplicates and sort
        $reminderDays = array_values(array_unique($validated['reminder_days_before']));
        rsort($reminderDays);

        try {
            $reminder = ServiceExpirationReminder::updateOrCreate(
                [
                    'service_id' => $service->id,
                    'customer_id' => $customer->id,
                ],
                [
                    'reminder_days_before' => $reminderDays,
                    'email_template' => $validated['email_template'] ?? null,
                    'is_active' => $request->has('is_active'),
                    'custom_message' => $validated['custom_message'] ?? null,
                    'metadata' => [
                        'updated_by' => auth()->id(),
                        'updated_at' => now()->toISOString(),
                        'override_service_default' => true,
                    ],
                ]
            );

            Log::info('Customer reminder configuration updated', [
                'service_id' => $service->id,
                'customer_id' => $customer->id,
                'reminder_id' => $reminder->id,
                'days' => $reminderDays,
            ]);

            return redirect()->route('admin.reminders.configure-service', $service)
                ->with('success', "Reminder configuration saved for {$customer->name}.");

        } catch (\Exception $e) {
            Log::error('Failed to save customer reminder configuration', [
                'service_id' => $service->id,
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save configuration. Please try again.');
        }
    }

    /**
     * Delete a reminder configuration.
     * 
     * DELETE /admin/reminders/{reminder}
     */
    public function destroy(ServiceExpirationReminder $reminder)
    {
        try {
            $serviceId = $reminder->service_id;
            $isCustomerSpecific = $reminder->customer_id !== null;

            $reminder->delete();

            Log::info('Reminder configuration deleted', [
                'reminder_id' => $reminder->id,
                'service_id' => $serviceId,
                'customer_id' => $reminder->customer_id,
            ]);

            $message = $isCustomerSpecific 
                ? 'Customer-specific reminder configuration deleted. Service default will be used.'
                : 'Service reminder configuration deleted.';

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Failed to delete reminder configuration', [
                'reminder_id' => $reminder->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Failed to delete configuration.');
        }
    }

    /**
     * Toggle active status of a reminder.
     * 
     * POST /admin/reminders/{reminder}/toggle
     */
    public function toggle(ServiceExpirationReminder $reminder)
    {
        try {
            $reminder->update([
                'is_active' => !$reminder->is_active,
                'metadata' => array_merge($reminder->metadata ?? [], [
                    'last_toggled_by' => auth()->id(),
                    'last_toggled_at' => now()->toISOString(),
                ]),
            ]);

            $status = $reminder->is_active ? 'enabled' : 'disabled';

            Log::info("Reminder configuration {$status}", [
                'reminder_id' => $reminder->id,
                'service_id' => $reminder->service_id,
                'customer_id' => $reminder->customer_id,
            ]);

            return redirect()->back()
                ->with('success', "Reminder configuration {$status} successfully.");

        } catch (\Exception $e) {
            Log::error('Failed to toggle reminder configuration', [
                'reminder_id' => $reminder->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Failed to toggle configuration.');
        }
    }

    /**
     * Bulk configure reminders for all subscription services.
     * 
     * GET /admin/reminders/bulk
     */
    public function bulkConfigure()
    {
        $services = Service::where('is_subscription', true)
            ->with(['expirationReminders' => function ($q) {
                $q->whereNull('customer_id');
            }])
            ->orderBy('title')
            ->get();

        return view('admin.reminders.bulk-configure', compact('services'));
    }

    /**
     * Save bulk reminder configurations.
     * 
     * POST /admin/reminders/bulk
     */
    public function storeBulkConfig(Request $request)
    {
        $validated = $request->validate([
            'services' => ['required', 'array', 'min:1'],
            'services.*.service_id' => ['required', 'exists:services,id'],
            'services.*.enabled' => ['boolean'],
            'services.*.days' => ['required', 'array', 'min:1'],
            'services.*.days.*' => ['integer', 'min:0', 'max:90'],
        ]);

        DB::beginTransaction();

        try {
            $created = 0;
            $updated = 0;

            foreach ($validated['services'] as $serviceConfig) {
                if (!($serviceConfig['enabled'] ?? false)) {
                    continue;
                }

                $days = array_values(array_unique($serviceConfig['days']));
                rsort($days);

                $reminder = ServiceExpirationReminder::updateOrCreate(
                    [
                        'service_id' => $serviceConfig['service_id'],
                        'customer_id' => null,
                    ],
                    [
                        'reminder_days_before' => $days,
                        'is_active' => true,
                        'metadata' => [
                            'bulk_configured_by' => auth()->id(),
                            'bulk_configured_at' => now()->toISOString(),
                        ],
                    ]
                );

                $reminder->wasRecentlyCreated ? $created++ : $updated++;
            }

            DB::commit();

            Log::info('Bulk reminder configuration completed', [
                'created' => $created,
                'updated' => $updated,
                'admin_id' => auth()->id(),
            ]);

            return redirect()->route('admin.reminders.index')
                ->with('success', "Bulk configuration completed: {$created} created, {$updated} updated.");

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Bulk reminder configuration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Bulk configuration failed. Please try again.');
        }
    }
}
