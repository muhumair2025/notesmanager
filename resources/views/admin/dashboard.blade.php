@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-xxl px-3 px-md-4 py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="dashboard-header">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-12">
                                <div class="header-content">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="header-icon">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </div>
                                        <div class="header-text">
                                            <h2 class="dashboard-title mb-0">Orders Dashboard</h2>
                                        </div>
                                    </div>
                                    <p class="dashboard-subtitle mb-0">
                                        <i class="fas fa-book me-2 text-primary"></i>
                                        Manage all semester notes orders efficiently
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 mt-3 mt-lg-0">
                                <div class="stats-section">
                                    <div class="d-flex flex-wrap gap-3 justify-content-lg-end justify-content-center">
                                        <div class="stat-card completed">
                                            <div class="stat-icon">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                            <div class="stat-content">
                                                <div class="stat-number">{{ $orders->where('is_completed', true)->count() }}</div>
                                                <div class="stat-label">Completed</div>
                                            </div>
                                        </div>
                                        <div class="stat-card pending">
                                            <div class="stat-icon">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div class="stat-content">
                                                <div class="stat-number">{{ $orders->where('is_completed', false)->count() }}</div>
                                                <div class="stat-label">Pending</div>
                                            </div>
                                        </div>
                                        <div class="stat-card total">
                                            <div class="stat-icon">
                                                <i class="fas fa-list-alt"></i>
                                            </div>
                                            <div class="stat-content">
                                                <div class="stat-number">{{ $orders->count() }}</div>
                                                <div class="stat-label">Total</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Search and Filter Form -->
                    <div class="mt-4">
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="search-filter-form">
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
                                    <label class="form-label small text-muted mb-1">Status Filter</label>
                                    <select name="status_filter" class="form-select">
                                        <option value="">All Status</option>
                                        @foreach(\App\Models\Order::getStatusOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ ($statusFilter ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
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
                            @if($statusFilter) with status "<strong>{{ \App\Models\Order::getStatusOptions()[$statusFilter] }}</strong>"@endif
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($orders->count() > 0)
                        <form action="{{ route('admin.mark-completed') }}" method="POST" id="bulkActionForm">
                            @csrf
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
                                                    <button type="submit" class="btn btn-success btn-sm flex-fill" id="markCompletedBtn" disabled>
                                                        <i class="fas fa-check me-1"></i>
                                                        <span class="d-none d-md-inline">Complete</span>
                                                        (<span id="selectedCount">0</span>)
                                                    </button>
                                                    <button type="button" class="btn btn-primary btn-sm flex-fill" id="printInvoicesBtn" disabled>
                                                        <i class="fas fa-print me-1"></i>
                                                        <span class="d-none d-md-inline">Print</span>
                                                        (<span id="printCount">0</span>)
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
                                            <th>Status</th>
                                            <th class="d-none d-md-table-cell">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr class="{{ $order->is_completed ? 'table-success' : '' }}">
                                                <td class="text-center">
                                                    @if(!$order->is_completed)
                                                        <input type="checkbox" 
                                                               name="order_ids[]" 
                                                               value="{{ $order->id }}" 
                                                               class="order-checkbox form-check-input">
                                                    @endif
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
                                                            <small>{{ Str::limit($order->remarks, 30) }}</small>
                                                            @if(strlen($order->remarks) > 30)
                                                                <button type="button" 
                                                                        class="btn btn-link btn-sm p-0 text-decoration-none" 
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
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
</div>
@endsection

@section('styles')
<style>
    /* Enhanced Card Design */
    .card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .card-header {
        border-radius: 16px 16px 0 0;
        padding: 2rem 2.5rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        position: relative;
        overflow: hidden;
    }
    
    .card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #0d6efd 0%, #6610f2 50%, #20c997 100%);
    }
    
    /* Dashboard Header Styling */
    .dashboard-header {
        position: relative;
        z-index: 1;
    }
    
    .header-content {
        padding: 0.5rem 0;
    }
    
    .header-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }
    
    .header-icon i {
        font-size: 1.5rem;
        color: white;
    }
    
    .dashboard-title {
        font-size: 2rem;
        font-weight: 700;
        color: #212529;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        margin: 0;
    }
    
    .dashboard-subtitle {
        font-size: 1rem;
        color: #6c757d;
        font-weight: 500;
        margin-top: 0.5rem;
    }
    
    /* Stats Cards */
    .stats-section {
        padding: 0.5rem 0;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        min-width: 120px;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card.completed {
        border-left: 4px solid #198754;
    }
    
    .stat-card.completed .stat-icon {
        background: linear-gradient(135deg, #198754 0%, #20c997 100%);
    }
    
    .stat-card.pending {
        border-left: 4px solid #ffc107;
    }
    
    .stat-card.pending .stat-icon {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }
    
    .stat-card.total {
        border-left: 4px solid #0d6efd;
    }
    
    .stat-card.total .stat-icon {
        background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
    }
    
    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .stat-icon i {
        font-size: 1rem;
        color: white;
    }
    
    .stat-content {
        flex: 1;
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #212529;
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.25rem;
    }
    
    /* Search Filter Form Styling */
    .search-filter-form {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }
    
    .search-filter-form .input-group-text {
        background: transparent;
        border-color: #dee2e6;
    }
    
    .search-filter-form .form-control,
    .search-filter-form .form-select {
        border-color: #dee2e6;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9rem;
    }
    
    .search-filter-form .form-control:focus,
    .search-filter-form .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }
    
    /* Bulk Actions Section */
    .bulk-actions-section {
        background: #f8f9fa;
        padding: 1.25rem;
        border-radius: 12px;
        border: 1px solid #e9ecef;
    }
    
    .bulk-actions-section .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .bulk-actions-section .form-select {
        border-radius: 8px;
        font-size: 0.875rem;
    }
    
    /* Table Improvements */
    .table-sm td {
        padding: 0.75rem 0.5rem;
        vertical-align: middle;
        border-color: #f1f3f4;
    }
    
    .table-sm th {
        padding: 0.875rem 0.5rem;
        font-weight: 600;
        font-size: 0.85rem;
        background: #f8f9fa;
        border-color: #f1f3f4;
        color: #495057;
    }
    
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Badge Styling */
    .badge-sm {
        font-size: 0.65rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 500;
    }
    
    .badge {
        font-weight: 500;
        border-radius: 6px;
    }
    
    /* Button Improvements */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-1px);
    }
    
    .btn-group .btn {
        border-radius: 8px;
    }
    
    .btn-group .btn:not(:last-child) {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }
    
    .btn-group .btn:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    
    /* Alert Improvements */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.25rem;
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
        .card-header {
            padding: 1.5rem 1.75rem;
        }
        
        .header-icon {
            width: 50px;
            height: 50px;
            margin-right: 0.75rem;
        }
        
        .header-icon i {
            font-size: 1.25rem;
        }
        
        .dashboard-title {
            font-size: 1.75rem;
        }
        
        .dashboard-subtitle {
            font-size: 0.9rem;
        }
        
        .stat-card {
            padding: 0.875rem 1rem;
            min-width: 110px;
        }
        
        .stat-number {
            font-size: 1.375rem;
        }
        
        .search-filter-form {
            padding: 1.25rem;
        }
        
        .bulk-actions-section {
            padding: 1rem;
        }
        
        .bulk-actions-section .btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 768px) {
        .card-header {
            padding: 1.25rem 1.5rem;
        }
        
        .header-icon {
            width: 45px;
            height: 45px;
            margin-right: 0.625rem;
        }
        
        .header-icon i {
            font-size: 1.125rem;
        }
        
        .dashboard-title {
            font-size: 1.5rem;
        }
        
        .dashboard-subtitle {
            font-size: 0.875rem;
        }
        
        .stats-section .d-flex {
            justify-content: center !important;
        }
        
        .stat-card {
            padding: 0.75rem 0.875rem;
            min-width: 100px;
            gap: 0.5rem;
        }
        
        .stat-icon {
            width: 35px;
            height: 35px;
        }
        
        .stat-icon i {
            font-size: 0.875rem;
        }
        
        .stat-number {
            font-size: 1.25rem;
        }
        
        .stat-label {
            font-size: 0.7rem;
        }
        
        .card-body {
            padding: 1.25rem !important;
        }
        
        .search-filter-form {
            padding: 1rem;
        }
        
        .bulk-actions-section {
            padding: 0.875rem;
        }
        
        .table-sm td {
            padding: 0.5rem 0.375rem;
            font-size: 0.85rem;
        }
        
        .table-sm th {
            padding: 0.625rem 0.375rem;
            font-size: 0.8rem;
        }
        
        .badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }
        
        .btn-group .btn {
            padding: 0.375rem 0.625rem;
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 576px) {
        .card-header {
            padding: 1rem 1.25rem;
        }
        
        .header-content .d-flex {
            flex-direction: column;
            align-items: center !important;
            text-align: center;
        }
        
        .header-icon {
            width: 50px;
            height: 50px;
            margin-right: 0;
            margin-bottom: 0.75rem;
        }
        
        .dashboard-title {
            font-size: 1.375rem;
        }
        
        .dashboard-subtitle {
            font-size: 0.8rem;
            text-align: center;
        }
        
        .stats-section {
            margin-top: 1rem;
        }
        
        .stat-card {
            flex-direction: column;
            text-align: center;
            padding: 0.75rem;
            min-width: 90px;
            gap: 0.375rem;
        }
        
        .stat-icon {
            width: 32px;
            height: 32px;
            margin: 0 auto 0.25rem;
        }
        
        .stat-number {
            font-size: 1.125rem;
        }
        
        .stat-label {
            font-size: 0.65rem;
        }
        
        .card-body {
            padding: 1rem !important;
        }
        
        .search-filter-form {
            padding: 0.875rem;
        }
        
        .bulk-actions-section {
            padding: 0.75rem;
        }
        
        .card-header .row {
            text-align: center;
        }
        
        .card-header .col-md-6:first-child {
            margin-bottom: 1rem;
        }
        
        .table-responsive {
            border: none;
            margin: -0.5rem;
        }
        
        .form-control, .form-select {
            font-size: 0.875rem;
            padding: 0.5rem 0.75rem;
        }
        
        .btn {
            font-size: 0.8rem;
            padding: 0.375rem 0.625rem;
        }
        
        .bulk-actions-section .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        
        .bulk-actions-section .form-select {
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 480px) {
        .search-filter-form .row > div {
            margin-bottom: 0.5rem;
        }
        
        .bulk-actions-section .d-flex {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .bulk-actions-section .d-flex.gap-2 {
            flex-direction: row;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
        const markCompletedBtn = document.getElementById('markCompletedBtn');
        const selectedCount = document.getElementById('selectedCount');
        const selectAllBtn = document.getElementById('selectAll');
        const deselectAllBtn = document.getElementById('deselectAll');
        const bulkActionForm = document.getElementById('bulkActionForm');

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            const count = checkedBoxes.length;
            selectedCount.textContent = count;
            markCompletedBtn.disabled = count === 0;
            
            // Update print button
            const printCount = document.getElementById('printCount');
            const printInvoicesBtn = document.getElementById('printInvoicesBtn');
            printCount.textContent = count;
            printInvoicesBtn.disabled = count === 0;
            
            // Update status controls
            const statusCount = document.getElementById('statusCount');
            const statusSelect = document.getElementById('statusSelect');
            const updateStatusBtn = document.getElementById('updateStatusBtn');
            statusCount.textContent = count;
            statusSelect.disabled = count === 0;
            updateStatusBtn.disabled = count === 0 || statusSelect.value === '';
            
            if (count > 0) {
                markCompletedBtn.classList.remove('btn-success');
                markCompletedBtn.classList.add('btn-success');
            }
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

        // Form submission confirmation
        bulkActionForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.order-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one order to mark as completed.');
                return;
            }

            const confirmMessage = `Are you sure you want to mark ${checkedBoxes.length} order(s) as completed?`;
            if (!confirm(confirmMessage)) {
                e.preventDefault();
            }
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
