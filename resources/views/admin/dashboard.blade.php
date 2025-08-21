@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Dashboard Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h2 mb-1">Orders Dashboard</h1>
                <p class="text-muted mb-0">Manage all semester notes orders efficiently</p>
            </div>
            <div class="d-flex align-items-center">
                <small class="text-muted">Last updated: {{ now()->format('M d, Y H:i') }}</small>
            </div>
        </div>
    </div>
</div>
    
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-check-circle text-success"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ $orders->where('is_completed', true)->count() }}</h5>
                            <small class="text-muted">Completed Orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-clock text-warning"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ $orders->where('is_completed', false)->count() }}</h5>
                            <small class="text-muted">Pending Orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-list-alt text-primary"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ $orders->count() }}</h5>
                            <small class="text-muted">Total Orders</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-money-check-alt text-info"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h5 class="mb-0">{{ $orders->where('fees_paid', true)->count() }}</h5>
                            <small class="text-muted">Fees Paid</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    
    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.dashboard') }}">
                        <div class="row g-3 align-items-end">
                                <div class="col-12 col-md-6">
                                    <label class="form-label small text-muted mb-1">Search Orders</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0 ps-0" 
                                               name="search" 
                                               value="{{ $searchTerm ?? '' }}"
                                               placeholder="Search by name, phone, email, order ID...">
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <label class="form-label small text-muted mb-1">Filter by Status/Fees</label>
                                    <select name="status_filter" class="form-select">
                                        <option value="">All Orders</option>
                                        <optgroup label="Order Status">
                                            @foreach(\App\Models\Order::getStatusOptions() as $value => $label)
                                                <option value="{{ $value }}" {{ ($statusFilter ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Fees Status">
                                            <option value="fees_paid" {{ ($statusFilter ?? '') === 'fees_paid' ? 'selected' : '' }}>Fees Paid</option>
                                            <option value="fees_not_paid" {{ ($statusFilter ?? '') === 'fees_not_paid' ? 'selected' : '' }}>Fees Not Paid</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-fill" title="Search">
                                            <i class="fas fa-search me-1"></i>
                                            <span class="d-none d-lg-inline">Search</span>
                                        </button>
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary" title="Clear filters">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table Section -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 p-md-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if($searchTerm || $statusFilter)
                        <div class="alert alert-info alert-dismissible fade show">
                            <i class="fas fa-info-circle me-2"></i>
                            Showing {{ $orders->count() }} filtered result(s)
                            @if($searchTerm) for "<strong>{{ $searchTerm }}</strong>"@endif
                            @if($statusFilter) 
                                @if($statusFilter === 'fees_paid')
                                    with fees status "<strong>Fees Paid</strong>"
                                @elseif($statusFilter === 'fees_not_paid')
                                    with fees status "<strong>Fees Not Paid</strong>"
                                @else
                                    with status "<strong>{{ \App\Models\Order::getStatusOptions()[$statusFilter] }}</strong>"
                                @endif
                            @endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($orders->count() > 0)
                        <div id="bulkActionForm">
                            <div class="bulk-actions-section mb-4">
                                <div class="row g-3 align-items-center">
                                    <div class="col-12 col-lg-3 col-md-4">
                                        <div class="btn-group w-100" role="group">
                                            <button type="button" id="selectAll" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-check-square me-1"></i>
                                                <span class="d-none d-lg-inline">Select All</span>
                                            </button>
                                            <button type="button" id="deselectAll" class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-square me-1"></i>
                                                <span class="d-none d-lg-inline">Clear</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9 col-md-8">
                                        <div class="row g-2">
                                            <div class="col-12 col-xl-6">
                                                <div class="d-flex gap-2 w-100">
                                                    <select class="form-select form-select-sm flex-grow-1" id="statusSelect" disabled style="min-width: 120px;">
                                                        <option value="">Select Status</option>
                                                        @foreach(\App\Models\Order::getStatusOptions() as $value => $label)
                                                            <option value="{{ $value }}">{{ $label }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="button" class="btn btn-warning btn-sm flex-shrink-0" id="updateStatusBtn" disabled>
                                                        <i class="fas fa-edit me-1"></i>
                                                        <span class="d-none d-lg-inline">Update</span>
                                                        (<span id="statusCount">0</span>)
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 col-xl-6">
                                                <div class="d-flex gap-2 w-100">
                                                    <button type="button" class="btn btn-primary btn-sm flex-fill" id="printInvoicesBtn" disabled>
                                                        <i class="fas fa-print me-1"></i>
                                                        <span class="d-none d-md-inline">Print</span>
                                                        (<span id="printCount">0</span>)
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm flex-fill" id="deleteOrdersBtn" disabled>
                                                        <i class="fas fa-trash me-1"></i>
                                                        <span class="d-none d-md-inline">Delete</span>
                                                        (<span id="deleteCount">0</span>)
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40" class="text-center">
                                                <i class="fas fa-check-square text-muted"></i>
                                            </th>
                                            <th class="text-nowrap">Order ID</th>
                                            <th class="d-none d-md-table-cell">Customer</th>
                                            <th class="d-table-cell d-md-none">Info</th>
                                            <th class="d-none d-lg-table-cell">Contact</th>
                                            <th class="d-none d-xl-table-cell">Address</th>
                                            <th class="d-none d-lg-table-cell">Semesters</th>
                                            <th class="d-none d-xl-table-cell">Remarks</th>
                                            <th class="d-none d-lg-table-cell">Fees</th>
                                            <th>Status</th>
                                            <th class="d-none d-md-table-cell">Date</th>
                                            <th width="80">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr class="{{ $order->is_completed ? 'table-success' : '' }}">
                                                <td class="text-center">
                                                    <input type="checkbox" 
                                                           name="order_ids[]" 
                                                           value="{{ $order->id }}" 
                                                           class="order-checkbox form-check-input">
                                                </td>
                                                <td class="text-nowrap">
                                                    <strong class="text-primary">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                                    @if($order->tracking_id)
                                                        <br><small class="text-muted"><i class="fas fa-barcode me-1"></i>{{ Str::limit($order->tracking_id, 10) }}</small>
                                                    @endif
                                                </td>
                                                
                                                <!-- Desktop Customer Column -->
                                                <td class="d-none d-md-table-cell">
                                                    <div>
                                                        <strong>{{ $order->name }}</strong><br>
                                                        <small class="text-muted"><i class="fas fa-phone me-1"></i>{{ $order->phone_number }}</small>
                                                    </div>
                                                </td>
                                                
                                                <!-- Mobile Info Column -->
                                                <td class="d-table-cell d-md-none">
                                                    <div>
                                                        <strong>{{ $order->name }}</strong><br>
                                                        <small class="text-muted"><i class="fas fa-phone me-1"></i>{{ $order->phone_number }}</small><br>
                                                        <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $order->city }}</small><br>
                                                        <div class="mt-1">
                                                            @foreach(array_slice($order->semesters, 0, 2) as $semester)
                                                                <span class="badge bg-primary badge-sm">{{ $semester }}</span>
                                                            @endforeach
                                                            @if(count($order->semesters) > 2)
                                                                <span class="badge bg-secondary badge-sm">+{{ count($order->semesters) - 2 }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class="d-none d-lg-table-cell">
                                                    <div>
                                                        <i class="fas fa-phone me-1"></i>{{ $order->phone_number }}<br>
                                                        @if($order->secondary_phone_number)
                                                            <i class="fas fa-phone-alt me-1"></i>{{ $order->secondary_phone_number }}
                                                        @endif
                                                        @if($order->email)
                                                            <br><small class="text-muted"><i class="fas fa-envelope me-1"></i>{{ Str::limit($order->email, 20) }}</small>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="d-none d-xl-table-cell">
                                                    <div style="max-width: 180px;">
                                                        <small>{{ Str::limit($order->full_address, 40) }}</small><br>
                                                        <strong class="text-muted">{{ $order->city }}, {{ $order->country }}</strong>
                                                    </div>
                                                </td>
                                                <td class="d-none d-lg-table-cell">
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($order->semesters as $semester)
                                                            <span class="badge bg-primary badge-sm">{{ $semester }}</span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="d-none d-xl-table-cell">
                                                    @if($order->remarks)
                                                        <div style="max-width: 150px;">
                                                            <small class="text-dark">{{ Str::limit($order->remarks, 30) }}</small>
                                                            @if(strlen($order->remarks) > 30)
                                                                <button type="button" 
                                                                        class="btn btn-link btn-sm p-0 text-decoration-none text-primary" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#remarksModal{{ $order->id }}">
                                                                    <small>more...</small>
                                                                </button>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <small class="text-muted">-</small>
                                                    @endif
                                                </td>
                                                <td class="d-none d-lg-table-cell">
                                                    <span class="badge {{ $order->fees_paid_badge }} d-inline-flex align-items-center">
                                                        <i class="fas {{ $order->fees_paid ? 'fa-check' : 'fa-times' }} me-1"></i>
                                                        {{ $order->fees_paid_label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge {{ $order->status_badge }} d-inline-flex align-items-center">
                                                        @switch($order->status)
                                                            @case('pending')
                                                                <i class="fas fa-clock me-1"></i>
                                                                @break
                                                            @case('printing')
                                                                <i class="fas fa-print me-1"></i>
                                                                @break
                                                            @case('packaging')
                                                                <i class="fas fa-box me-1"></i>
                                                                @break
                                                            @case('dispatched')
                                                                <i class="fas fa-shipping-fast me-1"></i>
                                                                @break
                                                            @case('completed')
                                                                <i class="fas fa-check me-1"></i>
                                                                @break
                                                        @endswitch
                                                        <span class="d-none d-sm-inline">{{ $order->status_label }}</span>
                                                    </span>
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    <small class="text-muted">{{ $order->created_at->format('M j, Y') }}<br>{{ $order->created_at->format('g:i A') }}</small>
                                                </td>
                                                <td>
                                                    <button type="button" 
                                                            class="btn btn-outline-primary btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editOrderModal{{ $order->id }}"
                                                            title="Edit Order">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                            @if($order->remarks && strlen($order->remarks) > 50)
                                                <!-- Remarks Modal -->
                                                <div class="modal fade" id="remarksModal{{ $order->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Remarks for Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $order->remarks }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Edit Order Modal -->
                                            <div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form id="editOrderForm{{ $order->id }}" method="POST" action="{{ route('admin.update-order', $order->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="row g-3">
                                                                    <!-- Customer Information -->
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Customer Name</label>
                                                                        <input type="text" class="form-control" name="name" value="{{ $order->name }}" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Email</label>
                                                                        <input type="email" class="form-control" name="email" value="{{ $order->email }}">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Phone Number</label>
                                                                        <input type="text" class="form-control" name="phone_number" value="{{ $order->phone_number }}" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Secondary Phone</label>
                                                                        <input type="text" class="form-control" name="secondary_phone_number" value="{{ $order->secondary_phone_number }}">
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label">Full Address</label>
                                                                        <textarea class="form-control" name="full_address" rows="2" required>{{ $order->full_address }}</textarea>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">City</label>
                                                                        <input type="text" class="form-control" name="city" value="{{ $order->city }}" required>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Country</label>
                                                                        <input type="text" class="form-control" name="country" value="{{ $order->country }}" required>
                                                                    </div>
                                                                    
                                                                    <!-- Order Details -->
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Status</label>
                                                                        <select class="form-select" name="status" required>
                                                                            @foreach(\App\Models\Order::getStatusOptions() as $value => $label)
                                                                                <option value="{{ $value }}" {{ $order->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Tracking ID</label>
                                                                        <input type="text" class="form-control" name="tracking_id" value="{{ $order->tracking_id }}">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Semesters (comma separated)</label>
                                                                        <input type="text" class="form-control" name="semesters" value="{{ implode(', ', $order->semesters) }}" required>
                                                                        <small class="form-text text-muted">e.g., 1st, 2nd, 3rd</small>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label">Fees Status</label>
                                                                        <select class="form-select" name="fees_paid">
                                                                            <option value="0" {{ !$order->fees_paid ? 'selected' : '' }}>Not Paid</option>
                                                                            <option value="1" {{ $order->fees_paid ? 'selected' : '' }}>Paid</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <label class="form-label">Remarks</label>
                                                                        <textarea class="form-control" name="remarks" rows="3">{{ $order->remarks }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-save me-1"></i>Update Order
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-{{ $searchTerm || $statusFilter ? 'search' : 'inbox' }} fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">{{ $searchTerm || $statusFilter ? 'No matching orders found' : 'No orders yet' }}</h5>
                            <p class="text-muted">
                                @if($searchTerm || $statusFilter)
                                    Try adjusting your search criteria or <a href="{{ route('admin.dashboard') }}">view all orders</a>.
                                @else
                                    Orders will appear here when customers submit them.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    /* Clean Dashboard Styles */
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        background: white;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    /* Statistics Cards */
    .bg-success.bg-opacity-10 {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }
    
    .bg-warning.bg-opacity-10 {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }
    
    .bg-primary.bg-opacity-10 {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
    
    .bg-info.bg-opacity-10 {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }
    
    /* Form Elements */
    .form-control, .form-select {
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
    
    .input-group-text {
        border: 1px solid #ced4da;
        background-color: #f8f9fa;
    }
    
    /* Buttons */
    .btn {
        border-radius: 6px;
        font-weight: 500;
    }
    
    /* Table */
    .table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        padding: 0.75rem;
    }
    
    .table td {
        padding: 0.75rem;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Status Badges */
    .badge {
        font-weight: 500;
        border-radius: 4px;
    }
    
    /* Pagination */
    .pagination {
        margin-bottom: 0;
    }
    
    .pagination .page-link {
        border: 1px solid #dee2e6;
        color: #495057;
        border-radius: 6px;
        margin: 0 2px;
    }
    
    .pagination .page-link:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    /* Alert Messages */
    .alert {
        border: none;
        border-radius: 6px;
        border-left: 4px solid;
    }
    
    .alert-success {
        border-left-color: #198754;
        background-color: #d1e7dd;
        color: #0a3622;
    }
    
    .alert-danger {
        border-left-color: #dc3545;
        background-color: #f8d7da;
        color: #58151c;
    }
    
    /* Modal */
    .modal-content {
        border: none;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        border-radius: 8px 8px 0 0;
    }
    
    .modal-footer {
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
        border-radius: 0 0 8px 8px;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .btn-group-vertical .btn {
            margin-bottom: 0.25rem;
        }
    }
    
    @media (max-width: 576px) {
        .h2 {
            font-size: 1.5rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .table th,
        .table td {
            padding: 0.5rem;
            font-size: 0.875rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            const count = checkedBoxes.length;
            
            // Update print button
            const printCount = document.getElementById('printCount');
            const printInvoicesBtn = document.getElementById('printInvoicesBtn');
            if (printCount) printCount.textContent = count;
            if (printInvoicesBtn) printInvoicesBtn.disabled = count === 0;
            
            // Update delete button
            const deleteCount = document.getElementById('deleteCount');
            const deleteOrdersBtn = document.getElementById('deleteOrdersBtn');
            if (deleteCount) deleteCount.textContent = count;
            if (deleteOrdersBtn) deleteOrdersBtn.disabled = count === 0;
            
            // Update status controls
            const statusCount = document.getElementById('statusCount');
            const statusSelect = document.getElementById('statusSelect');
            const updateStatusBtn = document.getElementById('updateStatusBtn');
            if (statusCount) statusCount.textContent = count;
            if (statusSelect) statusSelect.disabled = count === 0;
            if (updateStatusBtn) updateStatusBtn.disabled = count === 0 || (statusSelect && statusSelect.value === '');
        }



        // Individual checkbox functionality
        orderCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
            });
        });

        // Select All button
        selectAllBtn.addEventListener('click', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            updateSelectedCount();
        });

        // Deselect All button
        deselectAllBtn.addEventListener('click', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectedCount();
        });

        // Status update functionality
        const statusSelect = document.getElementById('statusSelect');
        const updateStatusBtn = document.getElementById('updateStatusBtn');
        
        statusSelect.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            updateStatusBtn.disabled = checkedBoxes.length === 0 || this.value === '';
        });
        
        updateStatusBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            const selectedStatus = statusSelect.value;
            
            if (checkedBoxes.length === 0) {
                alert('Please select at least one order to update status.');
                return;
            }
            
            if (!selectedStatus) {
                alert('Please select a status to update.');
                return;
            }
            
            const statusLabel = statusSelect.options[statusSelect.selectedIndex].text;
            const confirmMessage = `Are you sure you want to update ${checkedBoxes.length} order(s) status to "${statusLabel}"?`;
            
            if (!confirm(confirmMessage)) {
                return;
            }
            
            // Create a form to submit the selected order IDs and status
            const statusForm = document.createElement('form');
            statusForm.method = 'POST';
            statusForm.action = '{{ route("admin.update-status") }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            statusForm.appendChild(csrfToken);
            
            // Add status
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = selectedStatus;
            statusForm.appendChild(statusInput);
            
            // Add selected order IDs
            checkedBoxes.forEach(checkbox => {
                const orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'order_ids[]';
                orderIdInput.value = checkbox.value;
                statusForm.appendChild(orderIdInput);
            });
            
            // Submit the form
            document.body.appendChild(statusForm);
            statusForm.submit();
        });

        // Print invoices functionality
        const printInvoicesBtn = document.getElementById('printInvoicesBtn');
        printInvoicesBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select at least one order to print invoices.');
                return;
            }

            // Create a form to submit the selected order IDs for printing
            const printForm = document.createElement('form');
            printForm.method = 'POST';
            printForm.action = '{{ route("admin.print-invoices") }}';
            printForm.target = '_blank'; // Open in new window
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            printForm.appendChild(csrfToken);
            
            // Add selected order IDs
            checkedBoxes.forEach(checkbox => {
                const orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'order_ids[]';
                orderIdInput.value = checkbox.value;
                printForm.appendChild(orderIdInput);
            });
            
            // Submit the form
            document.body.appendChild(printForm);
            printForm.submit();
            document.body.removeChild(printForm);
        });

        // Delete orders functionality
        const deleteOrdersBtn = document.getElementById('deleteOrdersBtn');
        deleteOrdersBtn.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select at least one order to delete.');
                return;
            }

            // Confirm deletion
            const orderIds = Array.from(checkedBoxes).map(cb => cb.value);
            const confirmMessage = `Are you sure you want to delete ${checkedBoxes.length} order(s)?\n\nOrder IDs: ${orderIds.join(', ')}\n\nThis action cannot be undone!`;
            
            if (!confirm(confirmMessage)) {
                return;
            }

            // Create a form to submit the selected order IDs for deletion
            const deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = '{{ route("admin.delete-orders") }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            deleteForm.appendChild(csrfToken);
            
            // Add method override for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            deleteForm.appendChild(methodInput);
            
            // Add selected order IDs
            checkedBoxes.forEach(checkbox => {
                const orderIdInput = document.createElement('input');
                orderIdInput.type = 'hidden';
                orderIdInput.name = 'order_ids[]';
                orderIdInput.value = checkbox.value;
                deleteForm.appendChild(orderIdInput);
            });
            
            // Submit the form
            document.body.appendChild(deleteForm);
            deleteForm.submit();
            document.body.removeChild(deleteForm);
        });



        // Edit Order Modal Enhancement
        document.querySelectorAll('[data-bs-target^="#editOrderModal"]').forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-bs-target');
                const modal = document.querySelector(modalId);
                const form = modal.querySelector('form');
                
                // Reset any previous validation states
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            });
        });

        // Handle edit form submissions with validation
        document.querySelectorAll('form[id^="editOrderForm"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Updating...';
                submitBtn.disabled = true;
                
                // Basic client-side validation
                let isValid = true;
                const requiredFields = this.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        if (!field.nextElementSibling?.classList.contains('invalid-feedback')) {
                            const feedback = document.createElement('div');
                            feedback.className = 'invalid-feedback';
                            feedback.textContent = 'This field is required.';
                            field.parentNode.appendChild(feedback);
                        }
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                        const feedback = field.parentNode.querySelector('.invalid-feedback');
                        if (feedback) feedback.remove();
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    return;
                }
                
                // If validation passes, form will submit normally
                // Reset button state will happen on page reload
            });
        });

        // Initial update
        updateSelectedCount();
        
        // Auto-submit search form on filter changes (with debouncing)
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');
        const statusFilter = document.querySelector('select[name="status_filter"]');
        
        function debounceSearch() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.querySelector('form').submit();
            }, 500);
        }
        
        if (searchInput) {
            searchInput.addEventListener('input', debounceSearch);
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', () => {
                document.querySelector('form').submit();
            });
        }
    });
</script>
@endsection
