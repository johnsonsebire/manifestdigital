@extends('layouts.app')

@section('title', 'Tax Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Tax Management</h1>
                <a href="{{ route('admin.taxes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Tax
                </a>
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

            <!-- Taxes Card -->
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">All Taxes</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Actions:</div>
                            <a class="dropdown-item" href="{{ route('admin.taxes.regional') }}">
                                <i class="fas fa-globe fa-sm fa-fw me-2 text-gray-400"></i>
                                Regional Configuration
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($taxes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="taxTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Rate</th>
                                        <th>Status</th>
                                        <th>Default</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($taxes as $tax)
                                        <tr>
                                            <td>
                                                <strong>{{ $tax->name }}</strong>
                                                @if($tax->description)
                                                    <br><small class="text-muted">{{ $tax->description }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <code>{{ $tax->code }}</code>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $tax->type === 'percentage' ? 'primary' : 'secondary' }}">
                                                    {{ ucfirst($tax->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($tax->type === 'percentage')
                                                    {{ number_format($tax->rate, 2) }}%
                                                @else
                                                    {{ number_format($tax->rate, 2) }}
                                                @endif
                                                @if($tax->is_inclusive)
                                                    <br><small class="text-info">Inclusive</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $tax->is_active ? 'success' : 'danger' }}">
                                                    {{ $tax->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($tax->is_default)
                                                    <i class="fas fa-check text-success" title="Default Tax"></i>
                                                @else
                                                    <i class="fas fa-times text-muted" title="Not Default"></i>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $tax->created_at->format('M d, Y') }}
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.taxes.show', $tax) }}" 
                                                       class="btn btn-sm btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.taxes.edit', $tax) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($tax->invoices()->count() === 0)
                                                        <form action="{{ route('admin.taxes.destroy', $tax) }}" 
                                                              method="POST" 
                                                              style="display: inline;"
                                                              onsubmit="return confirm('Are you sure you want to delete this tax?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger" 
                                                                    title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-danger" 
                                                                disabled 
                                                                title="Cannot delete - used in invoices">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-4x text-gray-300 mb-4"></i>
                            <h4 class="text-gray-500">No Taxes Found</h4>
                            <p class="text-gray-400 mb-4">You haven't created any taxes yet.</p>
                            <a href="{{ route('admin.taxes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Your First Tax
                            </a>
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
    $('#taxTable').DataTable({
        "order": [[ 6, "desc" ]], // Sort by created date
        "pageLength": 25,
        "responsive": true
    });
});
</script>
@endpush
@endsection