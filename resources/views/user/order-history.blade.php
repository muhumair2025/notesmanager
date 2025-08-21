<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders - Notes Order Manager</title>
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
            max-width: 1000px;
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
            text-align: center;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .order-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: box-shadow 0.2s ease;
        }
        
        .order-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .order-header {
            background-color: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0;
        }
        
        .order-body {
            padding: 1rem;
        }
        
        .badge {
            font-size: 0.75rem;
        }
        
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-info { background-color: #0dcaf0; color: #000; }
        .badge-primary { background-color: #0d6efd; }
        .badge-secondary { background-color: #6c757d; }
        .badge-success { background-color: #198754; }
        .badge-danger { background-color: #dc3545; }
        
        .btn-cancel {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        
        .btn-cancel:hover {
            background-color: #bb2d3b;
            border-color: #b02a37;
            color: white;
        }
        
        @media (max-width: 768px) {
            .main-container {
                padding-top: 70px;
            }
            
            .card-header, .card-body, .order-header, .order-body {
                padding: 1rem;
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
            <div class="d-flex gap-2">
                <a href="{{ route('user.order-form') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-plus me-1"></i>New Order
                </a>
                <a href="{{ route('tracking.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-search me-1"></i>Track Order
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="main-card">
            <div class="card-header">
                <h1 class="h3 mb-2">
                    <i class="fas fa-history text-primary me-2"></i>My Orders
                </h1>
                <p class="text-muted mb-0">Order history for phone: <strong>{{ $phone }}</strong></p>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @if($errors->has('rate_limit'))
                            <strong>Rate Limit Exceeded:</strong>
                            <div class="mt-2">{{ $errors->first('rate_limit') }}</div>
                        @else
                            <strong>Error:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($orders->count() > 0)
                    @foreach($orders as $order)
                        <div class="order-card">
                            <div class="order-header">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h5 class="mb-1">
                                            <i class="fas fa-receipt me-2"></i>Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                        </h5>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('M d, Y h:i A') }}
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-2 mt-md-0">
                                        <span class="badge {{ $order->status_badge }} me-2">{{ $order->status_label }}</span>
                                        <span class="badge {{ $order->fees_paid_badge }}">
                                            {{ $order->fees_paid ? 'Fees Paid' : 'Fees Pending' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="order-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="mb-2"><strong>Name:</strong> {{ $order->name }}</p>
                                        <p class="mb-2"><strong>Phone:</strong> {{ $order->phone_number }}</p>
                                        <p class="mb-2"><strong>City:</strong> {{ $order->city }}, {{ $order->country }}</p>
                                        <p class="mb-2"><strong>Semesters:</strong> {{ $order->semesters_list }}</p>
                                        @if($order->tracking_id)
                                            <p class="mb-2">
                                                <strong>Tracking ID:</strong> 
                                                <code class="bg-light px-2 py-1 rounded">{{ $order->tracking_id }}</code>
                                            </p>
                                        @endif
                                        @if($order->remarks)
                                            <p class="mb-2"><strong>Remarks:</strong> {{ $order->remarks }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-4 text-md-end">
                                        @if($order->status === 'pending' && $order->created_at->diffInHours(now()) <= 2)
                                            <button type="button" class="btn btn-cancel btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $order->id }}">
                                                <i class="fas fa-times me-1"></i>Cancel Order
                                            </button>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                Can cancel within {{ 2 - $order->created_at->diffInHours(now()) }} hours
                                            </small>
                                        @elseif($order->status === 'pending')
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Cancellation window expired
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cancel Order Modal -->
                        @if($order->status === 'pending' && $order->created_at->diffInHours(now()) <= 2)
                            <div class="modal fade" id="cancelModal{{ $order->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                                Cancel Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('user.cancel-order', $order->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-info-circle me-2"></i>
                                                    <strong>Are you sure?</strong> This action cannot be undone.
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="phone_number{{ $order->id }}" class="form-label">
                                                        Confirm your phone number *
                                                    </label>
                                                    <input type="tel" 
                                                           class="form-control" 
                                                           id="phone_number{{ $order->id }}" 
                                                           name="phone_number" 
                                                           placeholder="Enter your phone number"
                                                           required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label for="reason{{ $order->id }}" class="form-label">
                                                        Reason for cancellation (optional)
                                                    </label>
                                                    <textarea class="form-control" 
                                                              id="reason{{ $order->id }}" 
                                                              name="reason" 
                                                              rows="3"
                                                              placeholder="Why are you cancelling this order?"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-arrow-left me-1"></i>Keep Order
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-times me-1"></i>Cancel Order
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 text-muted">No Orders Found</h4>
                        <p class="text-muted">No orders found for this phone number.</p>
                        <a href="{{ route('user.order-form') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Place Your First Order
                        </a>
                    </div>
                @endif
                
                <div class="text-center mt-4">
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <a href="{{ route('user.order-form') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>New Order
                        </a>
                        <a href="{{ route('tracking.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-search me-1"></i>Track Different Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
