<x-layouts.app title="Tax Details: {{ $tax->name }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Tax Details: {{ $tax->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.taxes.index') }}">Tax Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $tax->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.taxes.edit', $tax) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-2"></i>Edit Tax
                    </a>
                    <a href="{{ route('admin.taxes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Taxes
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Tax Information -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tax Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Name:</th>
                                            <td>{{ $tax->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Code:</th>
                                            <td><code>{{ $tax->code }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Type:</th>
                                            <td>
                                                <span class="badge badge-{{ $tax->type === 'percentage' ? 'primary' : 'secondary' }}">
                                                    {{ ucfirst($tax->type) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Rate:</th>
                                            <td>
                                                <strong>
                                                    @if($tax->type === 'percentage')
                                                        {{ number_format($tax->rate, 2) }}%
                                                    @else
                                                        {{ number_format($tax->rate, 2) }} GHS
                                                    @endif
                                                </strong>
                                                @if($tax->is_inclusive)
                                                    <span class="badge badge-info ms-2">Inclusive</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">Status:</th>
                                            <td>
                                                <span class="badge badge-{{ $tax->is_active ? 'success' : 'danger' }}">
                                                    {{ $tax->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Default Tax:</th>
                                            <td>
                                                @if($tax->is_default)
                                                    <i class="fas fa-check text-success"></i> Yes
                                                @else
                                                    <i class="fas fa-times text-muted"></i> No
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sort Order:</th>
                                            <td>{{ $tax->sort_order }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created:</th>
                                            <td>{{ $tax->created_at->format('M d, Y g:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($tax->description)
                                <div class="mt-3">
                                    <h6 class="font-weight-bold">Description:</h6>
                                    <p class="text-gray-700">{{ $tax->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Regional Configurations -->
                    @if($tax->regionalConfigurations()->count() > 0)
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Regional Configurations</h6>
                                <a href="{{ route('admin.taxes.regional') }}" class="btn btn-sm btn-outline-primary">
                                    Manage Regional Config
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>Currency</th>
                                                <th>Rate Override</th>
                                                <th>Inclusive Override</th>
                                                <th>Priority</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tax->regionalConfigurations as $config)
                                                <tr>
                                                    <td>
                                                        @if($config->country_code)
                                                            {{ $config->country_code }}
                                                        @else
                                                            <em class="text-muted">All Countries</em>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($config->currency)
                                                            {{ $config->currency->code }} ({{ $config->currency->name }})
                                                        @else
                                                            <em class="text-muted">All Currencies</em>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($config->rate_override !== null)
                                                            <strong>{{ number_format($config->rate_override, 2) }}%</strong>
                                                        @else
                                                            <em class="text-muted">Use default</em>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($config->is_inclusive !== null)
                                                            <span class="badge badge-{{ $config->is_inclusive ? 'info' : 'secondary' }}">
                                                                {{ $config->is_inclusive ? 'Inclusive' : 'Exclusive' }}
                                                            </span>
                                                        @else
                                                            <em class="text-muted">Use default</em>
                                                        @endif
                                                    </td>
                                                    <td>{{ $config->priority }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $config->is_active ? 'success' : 'danger' }}">
                                                            {{ $config->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Usage in Invoices -->
                    @if($tax->invoices()->count() > 0)
                        <div class="card shadow">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Usage in Invoices</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Invoice</th>
                                                <th>Client</th>
                                                <th>Tax Rate</th>
                                                <th>Tax Amount</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tax->invoices()->latest()->limit(10)->get() as $invoice)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('admin.invoices.show', $invoice) }}">
                                                            {{ $invoice->invoice_number }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $invoice->client_name ?? 'N/A' }}</td>
                                                    <td>
                                                        @php
                                                            $invoiceTax = $invoice->taxes()->where('tax_id', $tax->id)->first();
                                                        @endphp
                                                        @if($invoiceTax)
                                                            {{ number_format($invoiceTax->pivot->tax_rate, 2) }}%
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($invoiceTax)
                                                            {{ $invoice->currency->symbol }}{{ number_format($invoiceTax->pivot->tax_amount, 2) }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.invoices.show', $invoice) }}" 
                                                           class="btn btn-sm btn-outline-info">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($tax->invoices()->count() > 10)
                                    <div class="text-center mt-3">
                                        <p class="text-muted">Showing 10 of {{ $tax->invoices()->count() }} invoices</p>
                                        <a href="{{ route('admin.invoices.index', ['tax_id' => $tax->id]) }}" 
                                           class="btn btn-outline-primary">
                                            View All Invoices with this Tax
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Tax Statistics -->
                    <div class="card border-left-primary shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Tax Collected
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        @php
                                            $totalCollected = $tax->invoices()
                                                ->sum('invoice_taxes.tax_amount');
                                        @endphp
                                        {!! $currencyService->formatAmount($totalCollected ?? 0, $userCurrency->code) !!}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Statistics -->
                    <div class="card border-left-info shadow mb-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Invoices Using This Tax
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $tax->invoices()->count() }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.taxes.edit', $tax) }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Tax
                                </a>
                                
                                @if($tax->invoices()->count() === 0)
                                    <form action="{{ route('admin.taxes.destroy', $tax) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this tax? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="fas fa-trash me-2"></i>Delete Tax
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-outline-danger" disabled title="Cannot delete - used in invoices">
                                        <i class="fas fa-trash me-2"></i>Cannot Delete (Used in Invoices)
                                    </button>
                                @endif
                                
                                <a href="{{ route('admin.taxes.regional') }}" class="btn btn-outline-info">
                                    <i class="fas fa-globe me-2"></i>Regional Configuration
                                </a>
                                
                                <a href="{{ route('admin.invoices.index', ['tax_id' => $tax->id]) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-file-invoice me-2"></i>View Related Invoices
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>