<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Notifications\InvoiceSent;
use App\Notifications\InvoicePaymentReceived;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['customer', 'order'])
            ->latest('invoice_date');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by customer
        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->whereDate('invoice_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('invoice_date', '<=', $request->to_date);
        }

        // Search by invoice number
        if ($request->filled('search')) {
            $query->where('invoice_number', 'like', '%' . $request->search . '%');
        }

        $invoices = $query->paginate(15);

        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['customer', 'order.items.service']);
        
        return view('admin.invoices.show', compact('invoice'));
    }

    public function create(Order $order)
    {
        // Check if invoice already exists for this order
        if ($order->invoice) {
            return redirect()
                ->route('admin.invoices.show', $order->invoice)
                ->with('error', 'Invoice already exists for this order.');
        }

        return view('admin.invoices.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Check if invoice already exists
        if ($order->invoice) {
            return redirect()
                ->route('admin.invoices.show', $order->invoice)
                ->with('error', 'Invoice already exists for this order.');
        }

        $invoice = new Invoice([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'order_id' => $order->id,
            'customer_id' => $order->user_id,
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
