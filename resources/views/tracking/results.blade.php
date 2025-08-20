@extends('layouts.app')

@section('title', 'Order Tracking Results - SSA Technology')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div class="flex-grow-1">
                            <h2 class="mb-2 mb-md-0"><i class="fas fa-list-alt me-2"></i>Order Tracking Results</h2>
                            <p class="mb-0 opacity-90">
                                <span class="d-block d-md-inline">Results for:</span>
                                <strong class="d-block d-md-inline">{{ $request->name }}</strong>
                                <span class="d-none d-md-inline"> - </span>
                                <strong class="d-block d-md-inline">{{ $request->phone_number }}</strong>
                            </p>
                        </div>
                        <div class="flex-shrink-0 align-self-stretch align-self-md-auto">
                            <a href="{{ route('tracking.index') }}" class="btn btn-outline-primary w-100 w-md-auto">
                                <i class="fas fa-search me-1"></i>New Search
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="row">
                            @foreach($orders as $order)
                                <div class="col-lg-6 mb-4">
                                    <div class="card h-100 order-card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="fas fa-receipt me-2"></i>
                                                Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                            </h5>
                                            <span class="badge {{ $order->status_badge }} status-badge">
                                                {{ $order->status_label }}
                                            </span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted">Order Date</small>
                                                    <div class="fw-bold">{{ $order->created_at->format('M j, Y') }}</div>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Order Time</small>
                                                    <div class="fw-bold">{{ $order->created_at->format('g:i A') }}</div>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <small class="text-muted">Delivery Address</small>
                                                <div class="fw-bold">{{ $order->full_address }}</div>
                                                <div class="text-muted">{{ $order->city }}, {{ $order->country }}</div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <small class="text-muted">Semesters Ordered</small>
                                                <div class="mt-1">
                                                    @foreach($order->semesters as $semester)
                                                        <span class="badge bg-primary me-1 mb-1">{{ $semester }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            @if($order->remarks)
                                                <div class="mb-3">
                                                    <small class="text-muted">Remarks</small>
                                                    <div class="text-muted fst-italic">{{ $order->remarks }}</div>
                                                </div>
                                            @endif

                                            @if($order->tracking_id && $order->status === 'dispatched')
                                                <div class="mb-3">
                                                    <small class="text-muted">Package Tracking</small>
                                                    <div class="tracking-info">
                                                        <div class="fw-bold text-primary mb-2">
                                                            <i class="fas fa-barcode me-1"></i>
                                                            Tracking ID: {{ $order->tracking_id }}
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-outline-primary ms-2 copy-btn" 
                                                                    data-tracking-id="{{ $order->tracking_id }}"
                                                                    title="Copy tracking ID">
                                                                <i class="fas fa-copy"></i>
                                                            </button>
                                                        </div>
                                                        <div class="d-flex flex-wrap gap-2">
                                                            <a href="https://ep.gov.pk/track.asp" 
                                                               target="_blank" 
                                                               class="btn btn-sm btn-primary text-decoration-none"
                                                               rel="noopener noreferrer">
                                                                <i class="fas fa-external-link-alt me-1"></i>
                                                                Track on Pakistan Post
                                                            </a>
                                                        </div>
                                                        <div class="mt-1">
                                                            <small class="text-muted">
                                                                <i class="fas fa-info-circle me-1"></i>
                                                                Use tracking ID on Pakistan Post website
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <!-- Status Timeline -->
                                            <div class="status-timeline">
                                                <small class="text-muted">Order Progress</small>
                                                <div class="timeline mt-2">
                                                    <div class="timeline-item {{ $order->status === 'pending' || in_array($order->status, ['printing', 'packaging', 'dispatched', 'completed']) ? 'completed' : '' }}">
                                                        <div class="timeline-marker"></div>
                                                        <div class="timeline-content">
                                                            <small>Order Placed</small>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-item {{ in_array($order->status, ['printing', 'packaging', 'dispatched', 'completed']) ? 'completed' : ($order->status === 'printing' ? 'active' : '') }}">
                                                        <div class="timeline-marker"></div>
                                                        <div class="timeline-content">
                                                            <small>Printing</small>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-item {{ in_array($order->status, ['packaging', 'dispatched', 'completed']) ? 'completed' : ($order->status === 'packaging' ? 'active' : '') }}">
                                                        <div class="timeline-marker"></div>
                                                        <div class="timeline-content">
                                                            <small>Packaging</small>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-item {{ in_array($order->status, ['dispatched', 'completed']) ? 'completed' : ($order->status === 'dispatched' ? 'active' : '') }}">
                                                        <div class="timeline-marker"></div>
                                                        <div class="timeline-content">
                                                            <small>Dispatched</small>
                                                        </div>
                                                    </div>
                                                    <div class="timeline-item {{ $order->status === 'completed' ? 'completed' : '' }}">
                                                        <div class="timeline-marker"></div>
                                                        <div class="timeline-content">
                                                            <small>Delivered</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-muted">
                                            <small>
                                                <i class="fas fa-clock me-1"></i>
                                                Last updated: {{ $order->updated_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="text-center mt-4">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Need Help?</strong> If you have any questions about your orders, please contact our support team.
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Orders Found</h4>
                            <p class="text-muted mb-4">
                                We couldn't find any orders matching your search criteria.<br>
                                Please check your name and phone number and try again.
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('tracking.index') }}" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Try Again
                                </a>
                                <a href="{{ route('user.order-form') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-1"></i>Place New Order
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .order-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }
    
    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .status-badge {
        font-size: 0.75rem;
        padding: 0.5rem 0.75rem;
    }
    
    .badge-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800) !important;
        color: #000 !important;
    }
    
    .badge-info {
        background: linear-gradient(135deg, #17a2b8, #138496) !important;
    }
    
    .badge-primary {
        background: linear-gradient(135deg, #007bff, #0056b3) !important;
    }
    
    .badge-secondary {
        background: linear-gradient(135deg, #6c757d, #545b62) !important;
    }
    
    .badge-success {
        background: linear-gradient(135deg, #28a745, #1e7e34) !important;
    }
    
    .timeline {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        padding: 10px 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
    }
    
    .timeline-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    
    .timeline-marker {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #e9ecef;
        border: 2px solid #fff;
        margin-bottom: 5px;
        transition: all 0.3s ease;
    }
    
    .timeline-item.completed .timeline-marker {
        background: #28a745;
    }
    
    .timeline-item.active .timeline-marker {
        background: #007bff;
        animation: pulse 2s infinite;
    }
    
    .timeline-content small {
        font-size: 0.7rem;
        text-align: center;
        white-space: nowrap;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(0, 123, 255, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(0, 123, 255, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(0, 123, 255, 0);
        }
    }
    
    .tracking-info {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }
    
    .w-md-auto {
        width: auto !important;
    }
    
    @media (min-width: 768px) {
        .w-md-auto {
            width: auto !important;
        }
    }
    
    @media (max-width: 768px) {
        .col-lg-6 {
            margin-bottom: 1rem;
        }
        
        .card-header {
            padding: 1rem;
        }
        
        .card-header h2 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }
        
        .card-header p {
            font-size: 0.9rem;
            line-height: 1.4;
        }
        
        .card-header .btn {
            margin-top: 0.5rem;
            width: 100%;
        }
        
        .card-header h5 {
            font-size: 1rem;
        }
        
        .status-badge {
            font-size: 0.7rem;
            padding: 0.4rem 0.6rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .row.mb-3 {
            margin-bottom: 1rem !important;
        }
        
        .col-6 {
            margin-bottom: 0.5rem;
        }
        
        .timeline {
            flex-direction: column;
            gap: 8px;
            padding: 8px 0;
        }
        
        .timeline::before {
            display: none;
        }
        
        .timeline-item {
            flex-direction: row;
            justify-content: flex-start;
            width: 100%;
            align-items: center;
        }
        
        .timeline-marker {
            margin-right: 10px;
            margin-bottom: 0;
            width: 10px;
            height: 10px;
        }
        
        .timeline-content {
            flex: 1;
        }
        
        .timeline-content small {
            font-size: 0.75rem;
            text-align: left;
            white-space: normal;
        }
        
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.4rem 0.8rem;
        }
        
        .tracking-info {
            padding: 8px;
        }
        
        .fw-bold {
            font-size: 0.9rem;
        }
        
        .badge {
            font-size: 0.7rem;
            margin-bottom: 0.25rem;
        }
        
        .alert {
            padding: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .card-footer {
            padding: 0.75rem 1rem;
        }
    }
    
    @media (max-width: 576px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .card {
            margin-bottom: 1rem;
        }
        
        .card-header {
            padding: 0.75rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .row.mb-3 .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .btn-outline-primary {
            width: 100%;
            margin-top: 0.5rem;
        }
        
        .card-header .d-flex {
            gap: 1rem !important;
        }
        
        .card-header h2 {
            font-size: 1.1rem;
        }
        
        .card-header p {
            font-size: 0.85rem;
        }
        
        .d-flex.justify-content-center.gap-3 {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        
        .d-flex.justify-content-center.gap-3 .btn {
            width: 100%;
        }
    }
    
    .copy-btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        transition: all 0.2s ease;
    }
    
    .copy-btn:hover {
        transform: scale(1.05);
    }
    
    .copy-btn.copied {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }
    
    .copy-success {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #28a745;
        color: white;
        padding: 12px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideIn 0.3s ease;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Copy tracking ID functionality
    const copyButtons = document.querySelectorAll('.copy-btn');
    
    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const trackingId = this.getAttribute('data-tracking-id');
            const originalIcon = this.innerHTML;
            
            // Copy to clipboard
            navigator.clipboard.writeText(trackingId).then(() => {
                // Show success feedback
                this.innerHTML = '<i class="fas fa-check"></i>';
                this.classList.add('copied');
                
                // Show toast notification
                showCopySuccess();
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    this.innerHTML = originalIcon;
                    this.classList.remove('copied');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
                // Fallback for older browsers
                fallbackCopyTextToClipboard(trackingId, this, originalIcon);
            });
        });
    });
    
    function fallbackCopyTextToClipboard(text, button, originalIcon) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.top = "0";
        textArea.style.left = "0";
        textArea.style.position = "fixed";
        
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                button.innerHTML = '<i class="fas fa-check"></i>';
                button.classList.add('copied');
                showCopySuccess();
                
                setTimeout(() => {
                    button.innerHTML = originalIcon;
                    button.classList.remove('copied');
                }, 2000);
            }
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }
        
        document.body.removeChild(textArea);
    }
    
    function showCopySuccess() {
        const toast = document.createElement('div');
        toast.className = 'copy-success';
        toast.innerHTML = '<i class="fas fa-check me-2"></i>Tracking ID copied to clipboard!';
        
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 3000);
    }
});
</script>

@endsection
