<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::forCustomer(auth()->id())
            ->with('order')
            ->latest('invoice_date')
            ->paginate(15);

        return view('customer.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        // Ensure customer can only view their own invoices
        if ($invoice->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->load(['order.items.service']);
        
        return view('customer.invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        // Ensure customer can only download their own invoices
        if ($invoice->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->load(['customer', 'order.items.service']);
        
        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));
        
        return $pdf->download($invoice->invoice_number . '.pdf');
    }
}
