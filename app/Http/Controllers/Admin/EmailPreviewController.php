<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\User;
use App\Models\Form;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\ServiceExpirationReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailPreviewController extends Controller
{
    /**
     * Display email template previews for testing
     */
    public function index()
    {
        return view('admin.email-preview.index');
    }

    /**
     * Preview Order Status Changed email
     */
    public function orderStatusChanged()
    {
        $user = User::first();
        $order = Order::first() ?? $this->createSampleOrder();
        
        return view('emails.order-status-changed', [
            'notifiable' => $user,
            'order' => $order,
            'oldStatus' => 'pending',
            'newStatus' => 'approved',
        ]);
    }

    /**
     * Preview Invoice Sent email
     */
    public function invoiceSent()
    {
        $user = User::first();
        $invoice = Invoice::first() ?? $this->createSampleInvoice();
        
        return view('emails.invoice-sent', [
            'notifiable' => $user,
            'invoice' => $invoice,
        ]);
    }

    /**
     * Preview Invoice Payment Received email
     */
    public function invoicePaymentReceived()
    {
        $user = User::first();
        $invoice = Invoice::first() ?? $this->createSampleInvoice();
        $invoice->amount_paid = $invoice->total_amount * 0.5; // Partial payment
        
        return view('emails.invoice-payment-received', [
            'notifiable' => $user,
            'invoice' => $invoice,
            'amount' => $invoice->amount_paid,
        ]);
    }

    /**
     * Preview Project Created email
     */
    public function projectCreated()
    {
        $user = User::first();
        $project = Project::first() ?? $this->createSampleProject();
        
        return view('emails.project-created', [
            'notifiable' => $user,
            'project' => $project,
        ]);
    }

    /**
     * Preview New Project Message email
     */
    public function newProjectMessage()
    {
        $user = User::first();
        $project = Project::first() ?? $this->createSampleProject();
        $message = $this->createSampleMessage($project);
        
        return view('emails.new-project-message', [
            'notifiable' => $user,
            'project' => $project,
            'message' => $message,
        ]);
    }

    /**
     * Preview Form Submission email
     */
    public function formSubmission()
    {
        $form = Form::first() ?? $this->createSampleForm();
        $data = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1 (555) 123-4567',
            'company' => 'Acme Corporation',
            'message' => 'I would like to inquire about your web development services. Please contact me to discuss my project requirements.',
            'budget' => '$5,000 - $10,000',
            'timeline' => '2-3 months',
        ];
        
        return view('emails.form-submission', [
            'form' => $form,
            'data' => $data,
            'submissionId' => 123,
            'adminUrl' => route('admin.forms.submissions.index'),
        ]);
    }

    /**
     * Create a sample order for preview
     */
    private function createSampleOrder()
    {
        $order = new Order([
            'id' => 1,
            'uuid' => 'order-12345',
            'status' => 'approved',
            'total_amount' => 2500.00,
        ]);
        
        $order->id = 1;
        $order->exists = true;
        
        // Manually set the timestamps as Carbon instances
        $order->created_at = now();
        $order->updated_at = now();
        
        return $order;
    }

    /**
     * Create a sample invoice for preview
     */
    private function createSampleInvoice()
    {
        $invoice = new Invoice([
            'id' => 1,
            'invoice_number' => 'INV-2025-001',
            'subtotal' => 2000.00,
            'total_amount' => 2300.00,
            'amount_paid' => 0.00,
            'balance_due' => 2300.00,
            'status' => 'sent',
            'currency_id' => 1,
            'tax_breakdown' => json_encode([
                [
                    'tax_id' => 1,
                    'name' => 'Value Added Tax',
                    'code' => 'VAT',
                    'rate' => 15.00,
                    'amount' => 300.00,
                ]
            ]),
            'additional_fees' => 0.00,
            'notes' => 'Please remit payment within 30 days of invoice date.',
            'order_id' => 1,
            'paid_at' => null,
        ]);
        
        $invoice->id = 1;
        $invoice->exists = true;
        
        // Manually set the timestamps as Carbon instances
        $invoice->invoice_date = now();
        $invoice->due_date = now()->addDays(30);
        
        return $invoice;
    }

    /**
     * Create a sample project for preview
     */
    private function createSampleProject()
    {
        // Try to create a proper model instance if possible
        $project = new Project([
            'id' => 1,
            'title' => 'E-Commerce Website Development',
            'description' => 'Development of a modern e-commerce platform with custom features and integrations.',
            'status' => 'in_progress',
            'order_id' => 1,
        ]);
        
        // Set the ID manually since we're not saving to database
        $project->id = 1;
        $project->exists = true;
        
        // Manually set the timestamps as Carbon instances
        $project->start_date = now();
        $project->end_date = now()->addMonths(3);
        $project->created_at = now();
        
        return $project;
    }

    /**
     * Create a sample project message for preview
     */
    private function createSampleMessage($project)
    {
        $user = User::first() ?? new User(['name' => 'Project Manager', 'email' => 'pm@company.com']);
        
        $message = new ProjectMessage([
            'id' => 1,
            'project_id' => $project->id,
            'message' => 'Hi there! I wanted to update you on the progress of your e-commerce project. We have completed the initial design phase and are ready to move forward with development. Please review the mockups I\'ve attached and let me know if you have any feedback.',
            'subject' => 'Project Update - Design Phase Complete',
            'user_id' => $user->id ?? 1,
        ]);
        
        $message->id = 1;
        $message->exists = true;
        $message->user = $user;
        
        // Manually set the timestamps as Carbon instances
        $message->created_at = now();
        
        // Add mock attachments as a custom property
        $message->mock_attachments = [
            ['name' => 'homepage-mockup.pdf', 'size' => '2.4 MB'],
            ['name' => 'product-page-design.pdf', 'size' => '1.8 MB'],
        ];
        
        return $message;
    }

    /**
     * Create a sample form for preview
     */
    private function createSampleForm()
    {
        $form = new Form([
            'id' => 1,
            'name' => 'Contact Us',
            'slug' => 'contact-us',
            'description' => 'General contact form for inquiries',
        ]);
        
        $form->id = 1;
        $form->exists = true;
        
        return $form;
    }

    /**
     * Preview subscription expiring email
     */
    public function subscriptionExpiring(Request $request)
    {
        $daysRemaining = $request->input('days', 15);
        $subscription = $this->getSampleSubscription($daysRemaining);
        
        return view('emails.subscriptions.expiring', [
            'subscription' => $subscription,
            'daysRemaining' => $daysRemaining,
        ]);
    }

    /**
     * Generate preview for reminder configuration
     * 
     * POST /admin/email-preview/reminder
     */
    public function previewReminder(Request $request)
    {
        $validated = $request->validate([
            'service_id' => ['nullable', 'exists:services,id'],
            'subscription_id' => ['nullable', 'exists:subscriptions,id'],
            'days_before' => ['required', 'integer', 'min:0', 'max:90'],
            'custom_message' => ['nullable', 'string'],
            'template' => ['nullable', 'string'],
        ]);

        try {
            // Get subscription
            if (isset($validated['subscription_id'])) {
                $subscription = Subscription::with(['service', 'customer'])
                    ->findOrFail($validated['subscription_id']);
            } elseif (isset($validated['service_id'])) {
                $service = Service::findOrFail($validated['service_id']);
                $subscription = $this->getSampleSubscriptionForService($service);
            } else {
                $subscription = $this->getSampleSubscription($validated['days_before']);
            }

            // Adjust expiration date
            $subscription->expires_at = now()->addDays($validated['days_before']);
            $daysRemaining = $validated['days_before'];

            // Determine template
            $template = $validated['template'] ?? 'emails.subscriptions.expiring';

            // Render email
            $html = view($template, [
                'subscription' => $subscription,
                'daysRemaining' => $daysRemaining,
                'customMessage' => $validated['custom_message'] ?? null,
            ])->render();

            // Get subject line
            $subject = $this->getEmailSubject($subscription, $daysRemaining);

            return response()->json([
                'success' => true,
                'subject' => $subject,
                'html' => $html,
                'subscription' => [
                    'service' => $subscription->service->title,
                    'customer' => $subscription->customer->name,
                    'expires_at' => $subscription->expires_at->format('F j, Y'),
                    'days_remaining' => $daysRemaining,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Email preview generation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to generate preview: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Send test reminder email
     * 
     * POST /admin/email-preview/send-test
     */
    public function sendTestReminder(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'service_id' => ['nullable', 'exists:services,id'],
            'subscription_id' => ['nullable', 'exists:subscriptions,id'],
            'days_before' => ['required', 'integer', 'min:0', 'max:90'],
            'custom_message' => ['nullable', 'string'],
            'template' => ['nullable', 'string'],
        ]);

        try {
            // Get subscription
            if (isset($validated['subscription_id'])) {
                $subscription = Subscription::with(['service', 'customer'])
                    ->findOrFail($validated['subscription_id']);
            } elseif (isset($validated['service_id'])) {
                $service = Service::findOrFail($validated['service_id']);
                $subscription = $this->getSampleSubscriptionForService($service);
            } else {
                $subscription = $this->getSampleSubscription($validated['days_before']);
            }

            // Adjust expiration date
            $testSubscription = clone $subscription;
            $testSubscription->expires_at = now()->addDays($validated['days_before']);
            $daysRemaining = $validated['days_before'];

            // Determine template
            $template = $validated['template'] ?? 'emails.subscriptions.expiring';

            // Get subject and html
            $subject = "[TEST] " . $this->getEmailSubject($testSubscription, $daysRemaining);
            $html = view($template, [
                'subscription' => $testSubscription,
                'daysRemaining' => $daysRemaining,
                'customMessage' => $validated['custom_message'] ?? null,
            ])->render();

            // Send test email
            Mail::html($html, function ($message) use ($validated, $subject) {
                $message->to($validated['email'])
                    ->subject($subject);
            });

            Log::info('Test reminder email sent', [
                'to' => $validated['email'],
                'service_id' => $validated['service_id'] ?? null,
                'days_before' => $validated['days_before'],
                'sent_by' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => "Test email sent successfully to {$validated['email']}",
            ]);

        } catch (\Exception $e) {
            Log::error('Test email send failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Failed to send test email: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get sample subscription
     */
    private function getSampleSubscription(int $daysUntilExpiration = 15): Subscription
    {
        // Try to find an existing subscription
        $subscription = Subscription::with(['service', 'customer'])
            ->whereIn('status', ['active', 'pending_renewal'])
            ->first();

        if ($subscription) {
            return $subscription;
        }

        // Create sample subscription
        $service = Service::where('is_subscription', true)->first() 
            ?? $this->createSampleService();
        
        $customer = User::role('Customer')->first() 
            ?? $this->createSampleCustomer();

        $subscription = new Subscription([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'service_id' => $service->id,
            'customer_id' => $customer->id,
            'status' => 'active',
            'billing_interval' => $service->billing_interval ?? 'monthly',
            'price' => $service->price,
            'currency' => $service->currency ?? 'USD',
            'started_at' => now()->subMonths(3),
            'expires_at' => now()->addDays($daysUntilExpiration),
            'auto_renew' => false,
        ]);

        // Mark as existing so route model binding works
        $subscription->exists = true;
        $subscription->service = $service;
        $subscription->customer = $customer;

        return $subscription;
    }

    /**
     * Get sample subscription for specific service
     */
    private function getSampleSubscriptionForService(Service $service): Subscription
    {
        // Try to find existing subscription for this service
        $subscription = Subscription::with(['service', 'customer'])
            ->where('service_id', $service->id)
            ->whereIn('status', ['active', 'pending_renewal'])
            ->first();

        if ($subscription) {
            return $subscription;
        }

        // Create sample subscription
        $customer = User::role('Customer')->first() 
            ?? $this->createSampleCustomer();

        $subscription = new Subscription([
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'service_id' => $service->id,
            'customer_id' => $customer->id,
            'status' => 'active',
            'billing_interval' => $service->billing_interval ?? 'monthly',
            'price' => $service->price,
            'currency' => $service->currency ?? 'USD',
            'started_at' => now()->subMonths(3),
            'expires_at' => now()->addDays(15),
            'auto_renew' => false,
        ]);

        // Mark as existing so route model binding works
        $subscription->exists = true;
        $subscription->service = $service;
        $subscription->customer = $customer;

        return $subscription;
    }

    /**
     * Create sample service
     */
    private function createSampleService(): Service
    {
        $service = new Service([
            'title' => 'Premium Web Hosting',
            'description' => 'Professional web hosting with 24/7 support',
            'is_subscription' => true,
            'price' => 29.99,
            'currency' => 'USD',
            'billing_interval' => 'monthly',
            'subscription_duration_months' => 1,
            'renewal_discount_percentage' => 10,
        ]);

        $service->id = 1;
        $service->exists = true;

        return $service;
    }

    /**
     * Create sample customer
     */
    private function createSampleCustomer(): User
    {
        $customer = new User([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $customer->id = 1;
        $customer->exists = true;

        return $customer;
    }

    /**
     * Get email subject line
     */
    private function getEmailSubject(Subscription $subscription, int $daysRemaining): string
    {
        $service = $subscription->service->title;

        if ($daysRemaining > 1) {
            return "Your {$service} subscription expires in {$daysRemaining} days";
        } elseif ($daysRemaining === 1) {
            return "Your {$service} subscription expires tomorrow";
        } else {
            return "Your {$service} subscription expires today";
        }
    }
}