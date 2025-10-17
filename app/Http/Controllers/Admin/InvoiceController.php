<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Notifications\InvoiceSent;
use App\Notifications\InvoicePaymentReceived;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['customer', 'order']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->forCustomer($request->customer_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Date range filter
        if ($request->filled('date_from') || $request->filled('date_to')) {
            $query->dateRange($request->date_from, $request->date_to);
        }

        // Amount range filter
        if ($request->filled('amount_min') || $request->filled('amount_max')) {
            $query->amountRange($request->amount_min, $request->amount_max);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'invoice_date');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $invoices = $query->paginate(15)->withQueryString();

        // Get customers for filter dropdown
        $customers = \App\Models\User::role('Customer')->orderBy('name')->get();

        // Statistics
        $stats = [
            'total' => Invoice::count(),
            'draft' => Invoice::where('status', 'draft')->count(),
            'sent' => Invoice::where('status', 'sent')->count(),
            'paid' => Invoice::where('status', 'paid')->count(),
            'overdue' => Invoice::where('status', 'overdue')->count(),
            'total_outstanding' => Invoice::whereIn('status', ['sent', 'partial', 'overdue'])->sum('balance_due'),
        ];

        return view('admin.invoices.index', compact('invoices', 'customers', 'stats'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'order.items.service']);
        
        return view('admin.invoices.show', compact('invoice'));
    }

    public function create(Order $order = null)
    {
        // For order-based invoices
        if ($order) {
            // Check if invoice already exists for this order
            if ($order->invoice) {
                return redirect()
                    ->route('admin.invoices.show', $order->invoice)
                    ->with('error', 'Invoice already exists for this order.');
            }
            return view('admin.invoices.create', compact('order'));
        }

        // For manual invoices
        $customers = User::role('Customer')->orderBy('name')->get();
        return view('admin.invoices.create-manual', compact('customers'));
    }

    public function store(Request $request, Order $order = null)
    {
        // Validate based on invoice type (order-based or manual)
        $rules = [
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];

        // Manual invoice validation
        if (!$order) {
            $rules = array_merge($rules, [
                'client_type' => 'required|in:registered,manual',
                'customer_id' => 'required_if:client_type,registered|nullable|exists:users,id',
                'client_name' => 'required_if:client_type,manual|string|max:255',
                'client_email' => 'required_if:client_type,manual|email|max:255',
                'client_phone' => 'nullable|string|max:20',
                'client_address' => 'nullable|string',
                'client_company' => 'nullable|string|max:255',
                'subtotal' => 'required|numeric|min:0',
                'items' => 'required|array|min:1',
                'items.*.description' => 'required|string',
                'items.*.quantity' => 'required|numeric|min:1',
                'items.*.unit_price' => 'required|numeric|min:0',
            ]);
        }

        $request->validate($rules);

        // Order-based invoice
        if ($order) {
            // Check if invoice already exists
            if ($order->invoice) {
                return redirect()
                    ->route('admin.invoices.show', $order->invoice)
                    ->with('error', 'Invoice already exists for this order.');
            }

            $invoice = new Invoice([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'client_name' => $order->customer_name,
                'client_email' => $order->customer_email,
                'client_phone' => $order->customer_phone,
                'client_address' => $order->customer_address,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'subtotal' => $order->total,
                'tax_rate' => $request->tax_rate,
                'discount_amount' => $request->discount_amount ?? 0,
                'status' => 'draft',
                'notes' => $request->notes,
            ]);

            $invoice->calculateTotals();
            $invoice->save();

            return redirect()
                ->route('admin.invoices.show', $invoice)
                ->with('success', 'Invoice created successfully.');
        }

        // Manual invoice
        $invoiceData = [
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'subtotal' => $request->subtotal,
            'tax_rate' => $request->tax_rate,
            'discount_amount' => $request->discount_amount ?? 0,
            'status' => 'draft',
            'notes' => $request->notes,
            'metadata' => [
                'items' => $request->items,
            ],
        ];

        if ($request->client_type === 'registered') {
            $invoiceData['customer_id'] = $request->customer_id;
            $customer = User::find($request->customer_id);
            $invoiceData['client_name'] = $customer->name;
            $invoiceData['client_email'] = $customer->email;
        } else {
            $invoiceData['client_name'] = $request->client_name;
            $invoiceData['client_email'] = $request->client_email;
            $invoiceData['client_phone'] = $request->client_phone;
            $invoiceData['client_address'] = $request->client_address;
            $invoiceData['client_company'] = $request->client_company;
        }

        $invoice = new Invoice($invoiceData);
        $invoice->calculateTotals();
        $invoice->save();

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Manual invoice created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return redirect()
                ->route('admin.invoices.show', $invoice)
                ->with('error', 'Cannot edit a paid invoice.');
        }

        return view('admin.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return redirect()
                ->route('admin.invoices.show', $invoice)
                ->with('error', 'Cannot edit a paid invoice.');
        }

        $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $invoice->update([
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'tax_rate' => $request->tax_rate,
            'discount_amount' => $request->discount_amount ?? 0,
            'notes' => $request->notes,
        ]);

        $invoice->calculateTotals();
        $invoice->save();

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    public function send(Invoice $invoice)
    {
        if ($invoice->status === 'sent') {
            return back()->with('error', 'Invoice has already been sent.');
        }

        if ($invoice->status === 'paid') {
            return back()->with('error', 'Invoice is already paid.');
        }

        $invoice->markAsSent();

        // Send email notification to customer
        $invoice->customer->notify(new InvoiceSent($invoice));

        return back()->with('success', 'Invoice sent successfully.');
    }

    public function recordPayment(Request $request, Invoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $invoice->balance_due,
            'payment_method' => 'required|string',
            'payment_date' => 'required|date',
            'transaction_id' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $invoice->recordPayment($request->amount, [
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'transaction_id' => $request->transaction_id,
            'notes' => $request->notes,
            'recorded_by' => auth()->id(),
        ]);

        // Send payment confirmation to customer
        $invoice->customer->notify(new InvoicePaymentReceived($invoice, $request->amount));

        return back()->with('success', 'Payment recorded successfully.');
    }

    public function markAsPaid(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Invoice is already paid.');
        }

        $invoice->markAsPaid();

        // Send payment confirmation to customer
        $invoice->customer->notify(new InvoicePaymentReceived($invoice, $invoice->total_amount));

        return back()->with('success', 'Invoice marked as paid.');
    }

    public function cancel(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return back()->with('error', 'Cannot cancel a paid invoice.');
        }

        $invoice->cancel();

        return back()->with('success', 'Invoice cancelled successfully.');
    }

    public function exportPdf(Invoice $invoice)
    {
        $invoice->load(['customer', 'order.items.service']);
        
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        
        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
