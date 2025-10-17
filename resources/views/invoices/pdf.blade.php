<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
        }
        .header {
            margin-bottom: 40px;
        }
        .header h1 {
            font-size: 32px;
            margin: 0 0 10px 0;
            color: #000;
        }
        .header .status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background-color: #d1fae5; color: #065f46; }
        .status-sent { background-color: #dbeafe; color: #1e40af; }
        .status-overdue { background-color: #fee2e2; color: #991b1b; }
        .status-partial { background-color: #fef3c7; color: #92400e; }
        .status-draft { background-color: #f3f4f6; color: #374151; }
        .status-cancelled { background-color: #f3f4f6; color: #6b7280; }
        
        .row {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        .col-6 {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #000;
        }
        .info-block {
            line-height: 1.8;
        }
        .info-block .name {
            font-weight: bold;
            color: #000;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        table thead {
            background-color: #f9fafb;
        }
        table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 2px solid #e5e7eb;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        table tbody tr:last-child td {
            border-bottom: none;
        }
        .text-right {
            text-align: right;
        }
        .item-name {
            font-weight: 600;
            color: #000;
        }
        .item-desc {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }
        
        .totals {
            width: 350px;
            margin-left: auto;
            margin-top: 30px;
        }
        .totals-row {
            display: table;
            width: 100%;
            padding: 8px 0;
        }
        .totals-row.total {
            border-top: 2px solid #e5e7eb;
            font-weight: bold;
            font-size: 16px;
            padding-top: 12px;
        }
        .totals-row.balance {
            border-top: 1px solid #e5e7eb;
            font-weight: bold;
            font-size: 18px;
            padding-top: 12px;
        }
        .totals-label {
            display: table-cell;
            color: #6b7280;
        }
        .totals-value {
            display: table-cell;
            text-align: right;
            color: #000;
        }
        .totals-row.total .totals-label,
        .totals-row.total .totals-value,
        .totals-row.balance .totals-label,
        .totals-row.balance .totals-value {
            color: #000;
        }
        .totals-row .discount {
            color: #059669;
        }
        .totals-row .paid {
            color: #059669;
        }
        
        .notes {
            margin-top: 40px;
            padding: 20px;
            background-color: #f9fafb;
            border-left: 4px solid #3b82f6;
        }
        .notes h3 {
            font-size: 14px;
            margin: 0 0 10px 0;
            color: #000;
        }
        
        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
        
        .meta-info {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
        }
        .meta-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        .meta-label {
            display: table-cell;
            width: 150px;
            color: #6b7280;
            font-size: 12px;
        }
        .meta-value {
            display: table-cell;
            font-weight: 600;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>INVOICE</h1>
            <span class="status status-{{ $invoice->status }}">{{ strtoupper($invoice->status) }}</span>
        </div>

        <!-- Company and Customer Info -->
        <div class="row">
            <div class="col-6">
                <div class="section-title">From:</div>
                <div class="info-block">
                    <div class="name">{{ setting('company_name', 'Your Company Name') }}</div>
                    @if(setting('company_address'))
                        <div>{{ setting('company_address') }}</div>
                    @endif
                    @if(setting('company_city_state_zip'))
                        <div>{{ setting('company_city_state_zip') }}</div>
                    @endif
                    <div>{{ setting('company_email', 'contact@company.com') }}</div>
                    @if(setting('company_phone'))
                        <div>Phone: {{ setting('company_phone') }}</div>
                    @endif
                </div>
            </div>
            <div class="col-6">
                <div class="section-title">Bill To:</div>
                <div class="info-block">
                    @if($invoice->customer_id)
                        <!-- Registered Customer -->
                        <div class="name">{{ $invoice->customer->name }}</div>
                        <div>{{ $invoice->customer->email }}</div>
                        @if($invoice->customer->phone)
                            <div>{{ $invoice->customer->phone }}</div>
                        @endif
                    @else
                        <!-- Manual Client -->
                        <div class="name">{{ $invoice->client_name }}</div>
                        @if($invoice->client_company)
                            <div style="font-size: 12px; color: #6b7280;">{{ $invoice->client_company }}</div>
                        @endif
                        <div>{{ $invoice->client_email }}</div>
                        @if($invoice->client_phone)
                            <div>{{ $invoice->client_phone }}</div>
                        @endif
                        @if($invoice->client_address)
                            <div style="margin-top: 8px;">{{ $invoice->client_address }}</div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Invoice Meta Information -->
        <div class="meta-info">
            <div class="meta-row">
                <div class="meta-label">Invoice Number:</div>
                <div class="meta-value">{{ $invoice->invoice_number }}</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Invoice Date:</div>
                <div class="meta-value">{{ $invoice->invoice_date->format('F d, Y') }}</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Due Date:</div>
                <div class="meta-value">
                    {{ $invoice->due_date->format('F d, Y') }}
                    @if($invoice->isOverdue())
                        <span style="color: #dc2626;">({{ $invoice->days_overdue }} days overdue)</span>
                    @endif
                </div>
            </div>
            @if($invoice->order_id)
                <div class="meta-row">
                    <div class="meta-label">Related Order:</div>
                    <div class="meta-value">Order #{{ $invoice->order->id }}</div>
                </div>
            @endif
        </div>

        <!-- Line Items -->
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @if($invoice->order_id)
                    {{-- Order-based invoice items --}}
                    @foreach($invoice->order->items as $item)
                        <tr>
                            <td>
                                <div class="item-name">{{ $item->service->name }}</div>
                                @if($item->service->description)
                                    <div class="item-desc">{{ $item->service->description }}</div>
                                @endif
                            </td>
                            <td class="text-right">{{ $item->quantity }}</td>
                            <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-right">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    {{-- Manual invoice items --}}
                    @foreach($invoice->metadata['items'] ?? [] as $item)
                        <tr>
                            <td>
                                <div class="item-name">{{ $item['description'] }}</div>
                            </td>
                            <td class="text-right">{{ $item['quantity'] }}</td>
                            <td class="text-right">${{ number_format($item['unit_price'], 2) }}</td>
                            <td class="text-right">${{ number_format($item['quantity'] * $item['unit_price'], 2) }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="totals-row">
                <div class="totals-label">Subtotal:</div>
                <div class="totals-value">${{ number_format($invoice->subtotal, 2) }}</div>
            </div>
            
            @if($invoice->discount_amount > 0)
                <div class="totals-row">
                    <div class="totals-label">Discount:</div>
                    <div class="totals-value discount">-${{ number_format($invoice->discount_amount, 2) }}</div>
                </div>
            @endif
            
            <div class="totals-row">
                <div class="totals-label">Tax ({{ number_format($invoice->tax_rate, 2) }}%):</div>
                <div class="totals-value">${{ number_format($invoice->tax_amount, 2) }}</div>
            </div>
            
            <div class="totals-row total">
                <div class="totals-label">Total:</div>
                <div class="totals-value">${{ number_format($invoice->total_amount, 2) }}</div>
            </div>
            
            @if($invoice->amount_paid > 0)
                <div class="totals-row">
                    <div class="totals-label">Amount Paid:</div>
                    <div class="totals-value paid">-${{ number_format($invoice->amount_paid, 2) }}</div>
                </div>
                
                <div class="totals-row balance">
                    <div class="totals-label">Balance Due:</div>
                    <div class="totals-value">${{ number_format($invoice->balance_due, 2) }}</div>
                </div>
            @endif
        </div>

        <!-- Notes -->
        @if($invoice->notes)
            <div class="notes">
                <h3>Notes:</h3>
                <p>{{ $invoice->notes }}</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            @if(setting('invoice_terms'))
                <p>{{ setting('invoice_terms') }}</p>
            @else
                <p>Thank you for your business!</p>
            @endif
            @if(setting('invoice_footer_note'))
                <p>{{ setting('invoice_footer_note') }}</p>
            @else
                <p>If you have any questions about this invoice, please contact us at {{ setting('company_email', 'contact@company.com') }}</p>
            @endif
        </div>
    </div>
</body>
</html>
