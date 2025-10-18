@extends('layouts.app')

@section('title', 'Create New Tax')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Create New Tax</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.taxes.index') }}">Tax Management</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.taxes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Taxes
                </a>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tax Information</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.taxes.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Tax Name <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name') }}" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">e.g., Value Added Tax, Service Tax</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="code" class="form-label">Tax Code <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('code') is-invalid @enderror" 
                                                   id="code" 
                                                   name="code" 
                                                   value="{{ old('code') }}" 
                                                   required>
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">e.g., VAT, GST, NHIL</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="type" class="form-label">Tax Type <span class="text-danger">*</span></label>
                                            <select class="form-control @error('type') is-invalid @enderror" 
                                                    id="type" 
                                                    name="type" 
                                                    required>
                                                <option value="">Select Type</option>
                                                <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>
                                                    Percentage
                                                </option>
                                                <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>
                                                    Fixed Amount
                                                </option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="rate" class="form-label">Rate/Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" 
                                                       class="form-control @error('rate') is-invalid @enderror" 
                                                       id="rate" 
                                                       name="rate" 
                                                       value="{{ old('rate') }}" 
                                                       step="0.01" 
                                                       min="0" 
                                                       required>
                                                <span class="input-group-text" id="rate-suffix">%</span>
                                                @error('rate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">For percentage: enter value like 15 for 15%</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number" 
                                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                                   id="sort_order" 
                                                   name="sort_order" 
                                                   value="{{ old('sort_order', 0) }}" 
                                                   min="0">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">Lower numbers appear first</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Options</label>
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="is_active" 
                                                       name="is_active" 
                                                       value="1" 
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="is_default" 
                                                       name="is_default" 
                                                       value="1" 
                                                       {{ old('is_default') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_default">
                                                    Default Tax (applies automatically)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="checkbox" 
                                                       class="form-check-input" 
                                                       id="is_inclusive" 
                                                       name="is_inclusive" 
                                                       value="1" 
                                                       {{ old('is_inclusive') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_inclusive">
                                                    Tax Inclusive (already included in price)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Tax
                                    </button>
                                    <a href="{{ route('admin.taxes.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-left-info shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Tax Configuration Tips
                                    </div>
                                    <div class="text-gray-700">
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-2">
                                                <strong>Tax Code:</strong> Use standard codes like VAT, GST, NHIL for easy identification.
                                            </li>
                                            <li class="mb-2">
                                                <strong>Default Taxes:</strong> Will be automatically applied to new invoices.
                                            </li>
                                            <li class="mb-2">
                                                <strong>Tax Inclusive:</strong> Check this if the tax is already included in your product prices.
                                            </li>
                                            <li class="mb-0">
                                                <strong>Sort Order:</strong> Controls the order taxes appear in lists and calculations.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-left-warning shadow mt-4">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Ghana Tax Examples
                                    </div>
                                    <div class="text-gray-700">
                                        <ul class="list-unstyled mb-0">
                                            <li><strong>VAT:</strong> 15% (Percentage)</li>
                                            <li><strong>NHIL:</strong> 2.5% (Percentage)</li>
                                            <li><strong>COVID Levy:</strong> 1% (Percentage)</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-flag fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Update rate suffix based on tax type
    $('#type').change(function() {
        const type = $(this).val();
        const suffix = $('#rate-suffix');
        
        if (type === 'percentage') {
            suffix.text('%');
        } else if (type === 'fixed') {
            suffix.text('GHS'); // Or use dynamic currency
        } else {
            suffix.text('');
        }
    });
    
    // Auto-generate code from name if empty
    $('#name').on('input', function() {
        const name = $(this).val();
        const codeField = $('#code');
        
        if (codeField.val() === '') {
            let code = name.toUpperCase()
                          .replace(/[^A-Z0-9\s]/g, '')
                          .replace(/\s+/g, '')
                          .substring(0, 10);
            codeField.val(code);
        }
    });
});
</script>
@endpush
@endsection