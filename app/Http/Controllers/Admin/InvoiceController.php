<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Models\Currency;
use App\Models\Tax;
use App\Services\TaxService;
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
        $currencies = Currency::active()->ordered()->get();
        $taxes = Tax::active()->ordered()->get();
        
        // For order-based invoices
        if ($order) {
            // Check if invoice already exists for this order
            if ($order->invoice) {
                return redirect()
                    ->route('admin.invoices.show', $order->invoice)
                    ->with('error', 'Invoice already exists for this order.');
            }
            return view('admin.invoices.create', compact('order', 'currencies', 'taxes'));
        }

        // For manual invoices, get customers and pass null order
        $customers = User::role('Customer')->orderBy('name')->get();
        $order = null; // Explicitly set to null for the view
        return view('admin.invoices.create', compact('order', 'customers', 'currencies', 'taxes'));
    }

    public function store(Request $request, Order $order = null)
    {
        // Validate based on invoice type (order-based or manual)
        $rules = [
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'currency_id' => 'required|exists:currencies,id',
            'billing_country_code' => 'nullable|string|max:2',
            'taxes' => 'nullable|array',
            'taxes.*' => 'exists:taxes,id',
            'additional_fees' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            // Legacy support
            'tax_rate' => 'nullable|numeric|min:0|max:100',
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

            $currency = Currency::findOrFail($request->currency_id);
            
            $invoice = new Invoice([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'order_id' => $order->id,
                'customer_id' => $order->customer_id,
                'client_name' => $order->customer_name,
                'client_email' => $order->customer_email,
                'client_phone' => $order->customer_phone,
                'client_address' => $order->customer_address,
                'billing_country_code' => $request->billing_country_code,
                'currency_id' => $currency->id,
                'exchange_rate' => $currency->exchange_rate,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'subtotal' => $order->total,
                'discount_amount' => $request->discount_amount ?? 0,
                'additional_fees' => $request->additional_fees ?? 0,
                'status' => 'draft',
                'notes' => $request->notes,
                // Legacy support
                'tax_rate' => $request->tax_rate ?? 0,
            ]);

            $invoice->save();

            // Apply taxes using the new system
            if ($request->filled('taxes')) {
                $taxService = app(TaxService::class);
                $invoice = $taxService->applyTaxesToInvoice($invoice, $request->taxes);
            } else {
                // Fallback to legacy calculation
                $invoice->calculateTotals();
                $invoice->save();
            }

            return redirect()
                ->route('admin.invoices.show', $invoice)
                ->with('success', 'Invoice created successfully.');
        }

        // Manual invoice
        $currency = Currency::findOrFail($request->currency_id);
        
        $invoiceData = [
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'currency_id' => $currency->id,
            'exchange_rate' => $currency->exchange_rate,
            'billing_country_code' => $request->billing_country_code,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'subtotal' => $request->subtotal,
            'discount_amount' => $request->discount_amount ?? 0,
            'additional_fees' => $request->additional_fees ?? 0,
            'status' => 'draft',
            'notes' => $request->notes,
            'metadata' => [
                'items' => $request->items,
            ],
            // Legacy support
            'tax_rate' => $request->tax_rate ?? 0,
        ];

        if ($request->client_type === 'registered') {
            $invoiceData['customer_id'] = $request->customer_id;
            $customer = User::find($request->customer_id);
            $invoiceData['client_name'] = $customer->name;
            $invoiceData['client_email'] = $customer->email;
        } else {
            // Manual invoice - no registered customer
            $invoiceData['customer_id'] = null;
            $invoiceData['client_name'] = $request->client_name;
            $invoiceData['client_email'] = $request->client_email;
            $invoiceData['client_phone'] = $request->client_phone;
            $invoiceData['client_address'] = $request->client_address;
            $invoiceData['client_company'] = $request->client_company;
        }

        $invoice = new Invoice($invoiceData);
        $invoice->save();

        // Apply taxes using the new system
        if ($request->filled('taxes')) {
            $taxService = app(TaxService::class);
            $invoice = $taxService->applyTaxesToInvoice($invoice, $request->taxes);
        } else {
            // Fallback to legacy calculation
            $invoice->calculateTotals();
            $invoice->save();
        }

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

        $currencies = Currency::active()->ordered()->get();
        $taxes = Tax::active()->ordered()->get();
        
        // Get currently selected taxes
        $selectedTaxIds = $invoice->taxes->pluck('id')->toArray();

        return view('admin.invoices.edit', compact('invoice', 'currencies', 'taxes', 'selectedTaxIds'));
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
            'currency_id' => 'required|exists:currencies,id',
            'billing_country_code' => 'nullable|string|max:2',
            'taxes' => 'nullable|array',
            'taxes.*' => 'exists:taxes,id',
            'additional_fees' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            // Legacy support
            'tax_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        $currency = Currency::findOrFail($request->currency_id);

        $invoice->update([
            'currency_id' => $currency->id,
            'exchange_rate' => $currency->exchange_rate,
            'billing_country_code' => $request->billing_country_code,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'discount_amount' => $request->discount_amount ?? 0,
            'additional_fees' => $request->additional_fees ?? 0,
            'notes' => $request->notes,
            // Legacy support
            'tax_rate' => $request->tax_rate ?? 0,
        ]);

        // Apply taxes using the new system
        if ($request->filled('taxes')) {
            $taxService = app(TaxService::class);
            $invoice = $taxService->applyTaxesToInvoice($invoice, $request->taxes);
        } else {
            // Clear existing taxes and recalculate
            $invoice->taxes()->detach();
            $invoice->total_tax_amount = null;
            $invoice->tax_breakdown = null;
            $invoice->calculateTotals();
            $invoice->save();
        }

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

    /**
     * Get applicable taxes for a given country and currency (AJAX endpoint)
     */
    public function getApplicableTaxes(Request $request)
    {
        $request->validate([
            'country_code' => 'nullable|string|max:2',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        $taxService = app(TaxService::class);
        $applicableTaxes = $taxService->getApplicableTaxes(
            $request->country_code,
            $request->currency_id
        );

        return response()->json([
            'taxes' => $applicableTaxes->map(function ($tax) {
                return [
                    'id' => $tax->id,
                    'name' => $tax->name,
                    'code' => $tax->code,
                    'rate' => $tax->rate,
                    'type' => $tax->type,
                    'is_default' => $tax->is_default,
                    'description' => $tax->description,
                ];
            })
        ]);
    }

    /**
     * Calculate tax preview for given parameters (AJAX endpoint)
     */
    public function calculateTaxPreview(Request $request)
    {
        $request->validate([
            'subtotal' => 'required|numeric|min:0',
            'selected_taxes' => 'nullable|array',
            'selected_taxes.*' => 'exists:taxes,id',
            'country_code' => 'nullable|string|max:2',
            'currency_id' => 'required|exists:currencies,id',
        ]);

        $taxService = app(TaxService::class);
        
        if ($request->filled('selected_taxes')) {
            $taxes = Tax::whereIn('id', $request->selected_taxes)->get();
        } else {
            $taxes = $taxService->getApplicableTaxes(
                $request->country_code,
                $request->currency_id
            );
        }

        $calculation = $taxService->calculateTotalTax($request->subtotal, $taxes);
        $currency = Currency::find($request->currency_id);

        return response()->json([
            'calculation' => $calculation,
            'currency' => [
                'code' => $currency->code,
                'symbol' => $currency->symbol,
            ]
        ]);
    }
}
