<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\ProjectMessage;
use App\Models\User;
use App\Models\Form;
use Illuminate\Http\Request;

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
}