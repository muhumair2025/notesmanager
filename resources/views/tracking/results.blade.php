<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking Results - Notes Order Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 15px;
        }
        
        .main-container {
            max-width: 900px;
            margin: 0 auto;
            padding-top: 80px;
        }
        
        .main-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background: white;
            margin-bottom: 2rem;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #dee2e6;
            padding: 1.5rem;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .order-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.2s ease;
        }
        
        .order-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .order-card .card-header {
            background: #f8f9fa;
            padding: 1rem;
        }
        
        .order-card .card-body {
            padding: 1rem;
        }
        
        .status-badge {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .badge-printing {
            background-color: #cff4fc;
            color: #055160;
            border: 1px solid #9eeaf9;
        }
        
        .badge-packaging {
            background-color: #e2e3e5;
            color: #41464b;
            border: 1px solid #c4c8cc;
        }
        
        .badge-dispatched {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #b8daff;
        }
        
        .badge-completed {
            background-color: #d1e7dd;
            color: #0a3622;
            border: 1px solid #a3cfbb;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #0d6efd !important;
        }
        
        .info-section {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 1rem;
        }
        
        .semester-badge {
            background-color: #0d6efd;
            color: white;
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            margin: 0.2rem;
            display: inline-block;
        }
        
        .tracking-link {
            background-color: #e7f3ff;
            border: 1px solid #b8daff;
            border-radius: 6px;
            padding: 0.75rem;
            margin-top: 1rem;
        }
        
        .no-orders {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }
            
            .main-container {
                padding-top: 70px;
            }
            
            .card-header, .card-body {
                padding: 1rem;
            }
            
            .order-card .card-header,
            .order-card .card-body {
                padding: 0.75rem;
            }
            
            .d-flex-mobile {
            flex-direction: column;
                gap: 0.5rem;
        }
        
            .btn-mobile {
            width: 100%;
        }
    }
</style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-light bg-white border-bottom position-fixed top-0 w-100" style="z-index: 1000;">
        <div class="container-fluid px-3">
            <a class="navbar-brand" href="{{ route('tracking.index') }}">
                <i class="fas fa-graduation-cap me-2"></i>Notes Order Manager
            </a>
            <a href="{{ route('tracking.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-search me-1"></i>New Search
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="main-card">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div>
                        <h2 class="h4 mb-2">
                            <i class="fas fa-list-alt text-primary me-2"></i>Your Orders
                        </h2>
                        <p class="text-muted mb-0">
                            <strong>{{ $request->name }}</strong> • {{ $request->phone_number }}
                        </p>
                    </div>
                    <div class="d-flex gap-2 d-flex-mobile">
                        <a href="{{ route('tracking.index') }}" class="btn btn-outline-primary btn-mobile">
                            <i class="fas fa-search me-1"></i>New Search
                        </a>
                        <a href="{{ route('user.order-form') }}" class="btn btn-outline-success btn-mobile">
                            <i class="fas fa-plus me-1"></i>New Order
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card-body">
                @if($orders->count() > 0)
                    <div class="row">
                        @foreach($orders as $order)
                            <div class="col-lg-6 mb-4">
                                <div class="order-card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">
                                            <i class="fas fa-receipt me-2"></i>
                                            Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                        </h6>
                                        <span class="status-badge badge-{{ $order->status }}">
                                            @switch($order->status)
                                                @case('pending')
                                                    <i class="fas fa-clock me-1"></i>Pending
                                                    @break
                                                @case('printing')
                                                    <i class="fas fa-print me-1"></i>Printing
                                                    @break
                                                @case('packaging')
                                                    <i class="fas fa-box me-1"></i>Packaging
                                                    @break
                                                @case('dispatched')
                                                    <i class="fas fa-shipping-fast me-1"></i>Dispatched
                                                    @break
                                                @case('completed')
                                                    <i class="fas fa-check me-1"></i>Completed
                                                    @break
                                                @default
                                                    {{ ucfirst($order->status) }}
                                            @endswitch
                                        </span>
                                    </div>
                                    
                                    <div class="card-body">
                                        <!-- Order Info -->
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <small class="text-muted">Order Date</small>
                                                <div class="fw-semibold">{{ $order->created_at->format('M j, Y') }}</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted">Order Time</small>
                                                <div class="fw-semibold">{{ $order->created_at->format('g:i A') }}</div>
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="mb-3">
                                            <small class="text-muted">Delivery Address</small>
                                            <div class="fw-semibold">{{ Str::limit($order->full_address, 40) }}</div>
                                            <small class="text-muted">{{ $order->city }}, {{ $order->country }}</small>
                                        </div>

                                        <!-- Semesters -->
                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-2">Semesters Ordered</small>
                                            <div>
                                                @foreach($order->semesters as $semester)
                                                    <span class="semester-badge">{{ $semester }}</span>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Fees Status -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Payment Status</small>
                                                <span class="badge {{ $order->fees_paid ? 'bg-success' : 'bg-warning text-dark' }}">
                                                    <i class="fas fa-{{ $order->fees_paid ? 'check' : 'clock' }} me-1"></i>
                                                    {{ $order->fees_paid ? 'Paid' : 'Pending' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Tracking Info -->
                                        @if($order->tracking_id)
                                            <div class="tracking-link">
                                                <small class="text-muted d-block">Tracking ID</small>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong class="text-primary">{{ $order->tracking_id }}</strong>
                                                    <a href="https://ep.gov.pk/track.asp" 
                                                       target="_blank" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-external-link-alt me-1"></i>Track
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Remarks -->
                                        @if($order->remarks)
                                            <div class="mt-3">
                                                <small class="text-muted">Special Instructions</small>
                                                <div class="info-section">
                                                    <small>{{ $order->remarks }}</small>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Summary -->
                    <div class="info-section mt-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="fw-bold text-primary">{{ $orders->count() }}</div>
                                <small class="text-muted">Total Orders</small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-success">{{ $orders->where('status', 'completed')->count() }}</div>
                                <small class="text-muted">Completed</small>
                            </div>
                            <div class="col-4">
                                <div class="fw-bold text-warning">{{ $orders->where('fees_paid', false)->count() }}</div>
                                <small class="text-muted">Payment Pending</small>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="no-orders">
                        <div class="mb-4">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Orders Found</h5>
                            <p class="text-muted">
                                We couldn't find any orders matching your details.<br>
                                Please check your name and phone number and try again.
                            </p>
                        </div>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('tracking.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-search me-1"></i>Try Again
                            </a>
                            <a href="{{ route('user.order-form') }}" class="btn btn-outline-success">
                                <i class="fas fa-plus me-1"></i>Place New Order
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-refresh page every 30 seconds if there are pending orders
        document.addEventListener('DOMContentLoaded', function() {
            const hasPendingOrders = {{ $orders->whereIn('status', ['pending', 'printing', 'packaging', 'dispatched'])->count() > 0 ? 'true' : 'false' }};
            
            if (hasPendingOrders) {
                setTimeout(() => {
                    window.location.reload();
                }, 30000); // 30 seconds
    }
});
</script>
</body>
</html>