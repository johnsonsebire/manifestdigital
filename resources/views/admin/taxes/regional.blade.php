@extends('layouts.app')

@section('title', 'Regional Tax Configuration')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Regional Tax Configuration</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.taxes.index') }}">Tax Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Regional Configuration</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addRegionalTaxModal">
                        <i class="fas fa-plus me-2"></i>Add Regional Tax
                    </button>
                    <a href="{{ route('admin.taxes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Taxes
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Regional Tax Configurations -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Regional Tax Configurations</h6>
                </div>
                <div class="card-body">
                    @if($regionalTaxes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="regionalTaxTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tax</th>
                                        <th>Country</th>
                                        <th>Currency</th>
                                        <th>Rate Override</th>
                                        <th>Inclusive Override</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regionalTaxes as $regionalTax)
                                        <tr>
                                            <td>
                                                <strong>{{ $regionalTax->tax->name }}</strong>
                                                <br><small class="text-muted">{{ $regionalTax->tax->code }}</small>
                                                <br><small class="text-info">
                                                    Default: {{ number_format($regionalTax->tax->rate, 2) }}%
                                                </small>
                                            </td>
                                            <td>
                                                @if($regionalTax->country_code)
                                                    <span class="badge badge-secondary">{{ $regionalTax->country_code }}</span>
                                                @else
                                                    <em class="text-muted">All Countries</em>
                                                @endif
                                            </td>
                                            <td>
                                                @if($regionalTax->currency)
                                                    <strong>{{ $regionalTax->currency->code }}</strong>
                                                    <br><small class="text-muted">{{ $regionalTax->currency->name }}</small>
                                                @else
                                                    <em class="text-muted">All Currencies</em>
                                                @endif
                                            </td>
                                            <td>
                                                @if($regionalTax->rate_override !== null)
                                                    <strong class="text-warning">{{ number_format($regionalTax->rate_override, 2) }}%</strong>
                                                    <br><small class="text-muted">
                                                        Override from {{ number_format($regionalTax->tax->rate, 2) }}%
                                                    </small>
                                                @else
                                                    <em class="text-muted">Use default rate</em>
                                                @endif
                                            </td>
                                            <td>
                                                @if($regionalTax->is_inclusive !== null)
                                                    <span class="badge badge-{{ $regionalTax->is_inclusive ? 'info' : 'secondary' }}">
                                                        {{ $regionalTax->is_inclusive ? 'Inclusive' : 'Exclusive' }}
                                                    </span>
                                                    <br><small class="text-muted">
                                                        Override from {{ $regionalTax->tax->is_inclusive ? 'Inclusive' : 'Exclusive' }}
                                                    </small>
                                                @else
                                                    <em class="text-muted">Use default setting</em>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-primary">{{ $regionalTax->priority }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $regionalTax->is_active ? 'success' : 'danger' }}">
                                                    {{ $regionalTax->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-primary edit-regional-tax"
                                                            data-id="{{ $regionalTax->id }}"
                                                            data-tax-id="{{ $regionalTax->tax_id }}"
                                                            data-country-code="{{ $regionalTax->country_code }}"
                                                            data-currency-id="{{ $regionalTax->currency_id }}"
                                                            data-rate-override="{{ $regionalTax->rate_override }}"
                                                            data-is-inclusive="{{ $regionalTax->is_inclusive }}"
                                                            data-priority="{{ $regionalTax->priority }}"
                                                            data-is-active="{{ $regionalTax->is_active ? 1 : 0 }}"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.taxes.regional.destroy', $regionalTax) }}" 
                                                          method="POST" 
                                                          style="display: inline;"
                                                          onsubmit="return confirm('Are you sure you want to delete this regional tax configuration?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-globe fa-4x text-gray-300 mb-4"></i>
                            <h4 class="text-gray-500">No Regional Configurations</h4>
                            <p class="text-gray-400 mb-4">Configure different tax rates for specific countries or currencies.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRegionalTaxModal">
                                <i class="fas fa-plus me-2"></i>Add First Regional Configuration
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Regional Tax Modal -->
<div class="modal fade" id="addRegionalTaxModal" tabindex="-1" aria-labelledby="addRegionalTaxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="regionalTaxForm" action="{{ route('admin.taxes.regional.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addRegionalTaxModalLabel">Add Regional Tax Configuration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="tax_id" class="form-label">Tax <span class="text-danger">*</span></label>
                                <select class="form-control" id="tax_id" name="tax_id" required>
                                    <option value="">Select Tax</option>
                                    @foreach($taxes as $tax)
                                        <option value="{{ $tax->id }}">
                                            {{ $tax->name }} ({{ $tax->code }}) - {{ number_format($tax->rate, 2) }}%
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control" 
                                       id="priority" 
                                       name="priority" 
                                       value="1" 
                                       min="1" 
                                       required>
                                <small class="form-text text-muted">Lower numbers have higher priority</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="country_code" class="form-label">Country Code</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="country_code" 
                                       name="country_code" 
                                       maxlength="2" 
                                       placeholder="e.g., GH, US">
                                <small class="form-text text-muted">Leave empty for all countries</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="currency_id" class="form-label">Currency</label>
                                <select class="form-control" id="currency_id" name="currency_id">
                                    <option value="">All Currencies</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->id }}">
                                            {{ $currency->code }} - {{ $currency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="rate_override" class="form-label">Rate Override (%)</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="rate_override" 
                                       name="rate_override" 
                                       step="0.01" 
                                       min="0">
                                <small class="form-text text-muted">Leave empty to use default rate</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="is_inclusive" class="form-label">Tax Inclusive Override</label>
                                <select class="form-control" id="is_inclusive" name="is_inclusive">
                                    <option value="">Use Default Setting</option>
                                    <option value="1">Inclusive</option>
                                    <option value="0">Exclusive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="is_active" 
                                   name="is_active" 
                                   value="1" 
                                   checked>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Configuration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#regionalTaxTable').DataTable({
        "order": [[ 5, "asc" ]], // Sort by priority
        "pageLength": 25,
        "responsive": true
    });

    // Handle edit regional tax
    $('.edit-regional-tax').click(function() {
        const data = $(this).data();
        
        $('#addRegionalTaxModalLabel').text('Edit Regional Tax Configuration');
        $('#regionalTaxForm').attr('action', '/admin/taxes/regional/' + data.id);
        $('#regionalTaxForm').append('<input type="hidden" name="_method" value="PUT">');
        
        $('#tax_id').val(data.taxId);
        $('#country_code').val(data.countryCode || '');
        $('#currency_id').val(data.currencyId || '');
        $('#rate_override').val(data.rateOverride || '');
        $('#is_inclusive').val(data.isInclusive !== null ? data.isInclusive : '');
        $('#priority').val(data.priority);
        $('#is_active').prop('checked', data.isActive);
        
        $('#addRegionalTaxModal').modal('show');
    });

    // Reset form when modal is closed
    $('#addRegionalTaxModal').on('hidden.bs.modal', function() {
        $('#addRegionalTaxModalLabel').text('Add Regional Tax Configuration');
        $('#regionalTaxForm').attr('action', '{{ route('admin.taxes.regional.store') }}');
        $('#regionalTaxForm input[name="_method"]').remove();
        $('#regionalTaxForm')[0].reset();
        $('#is_active').prop('checked', true);
    });
});
</script>
@endpush
@endsection