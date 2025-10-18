<x-layouts.app title="Edit Tax: {{ $tax->name }}">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Edit Tax: {{ $tax->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.taxes.index') }}">Tax Management</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.taxes.show', $tax) }}">{{ $tax->name }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.taxes.show', $tax) }}" class="btn btn-info me-2">
                        <i class="fas fa-eye me-2"></i>View Tax
                    </a>
                    <a href="{{ route('admin.taxes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Taxes
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tax Information</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.taxes.update', $tax) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label">Tax Name <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $tax->name) }}" 
                                                   required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="code" class="form-label">Tax Code <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   class="form-control @error('code') is-invalid @enderror" 
                                                   id="code" 
                                                   name="code" 
                                                   value="{{ old('code', $tax->code) }}" 
                                                   required>
                                            @error('code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3">{{ old('description', $tax->description) }}</textarea>
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
                                                <option value="percentage" {{ old('type', $tax->type) === 'percentage' ? 'selected' : '' }}>
                                                    Percentage
                                                </option>
                                                <option value="fixed" {{ old('type', $tax->type) === 'fixed' ? 'selected' : '' }}>
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
                                                       value="{{ old('rate', $tax->rate) }}" 
                                                       step="0.01" 
                                                       min="0" 
                                                       required>
                                                <span class="input-group-text" id="rate-suffix">
                                                    {{ $tax->type === 'percentage' ? '%' : 'GHS' }}
                                                </span>
                                                @error('rate')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
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
                                                   value="{{ old('sort_order', $tax->sort_order) }}" 
                                                   min="0">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                                       {{ old('is_active', $tax->is_active) ? 'checked' : '' }}>
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
                                                       {{ old('is_default', $tax->is_default) ? 'checked' : '' }}>
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
                                                       {{ old('is_inclusive', $tax->is_inclusive) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_inclusive">
                                                    Tax Inclusive (already included in price)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Tax
                                    </button>
                                    <a href="{{ route('admin.taxes.show', $tax) }}" class="btn btn-secondary ms-2">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Usage Information -->
                    <div class="card border-left-info shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Tax Usage
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $tax->invoices()->count() }} Invoices
                                    </div>
                                    @if($tax->invoices()->count() > 0)
                                        <div class="text-gray-600">
                                            Used in {{ $tax->invoices()->count() }} invoice(s)
                                        </div>
                                    @else
                                        <div class="text-gray-600">
                                            Not used in any invoices yet
                                        </div>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Regional Configuration -->
                    @if($tax->regionalConfigurations()->count() > 0)
                        <div class="card border-left-primary shadow mt-4">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                    Regional Configurations
                                </div>
                                @foreach($tax->regionalConfigurations as $config)
                                    <div class="mb-2">
                                        <strong>
                                            @if($config->country_code)
                                                {{ $config->country_code }}
                                            @else
                                                Global
                                            @endif
                                            @if($config->currency)
                                                ({{ $config->currency->code }})
                                            @endif
                                        </strong>
                                        @if($config->rate_override !== null)
                                            <br><small class="text-muted">
                                                Override Rate: {{ $config->rate_override }}%
                                            </small>
                                        @endif
                                    </div>
                                @endforeach
                                <a href="{{ route('admin.taxes.regional') }}" class="btn btn-sm btn-outline-primary mt-2">
                                    Manage Regional Config
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Warning if used in invoices -->
                    @if($tax->invoices()->count() > 0)
                        <div class="card border-left-warning shadow mt-4">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Important Notice
                                </div>
                                <div class="text-gray-700">
                                    This tax is currently used in {{ $tax->invoices()->count() }} invoice(s). 
                                    Changes to the rate or type may affect existing invoices.
                                </div>
                            </div>
                        </div>
                    @endif
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
});
</script>
@endpush

</x-layouts.app>