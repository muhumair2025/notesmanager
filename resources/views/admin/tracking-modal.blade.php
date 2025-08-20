@extends('layouts.app')

@section('title', 'Add Tracking IDs - Admin Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2><i class="fas fa-shipping-fast me-3"></i>Add Tracking IDs for Dispatch</h2>
                    <p class="mb-0 mt-2 opacity-90">Please provide tracking ID for each order being dispatched</p>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Pakistan Post Tracking:</strong> These tracking IDs will be linked to 
                        <a href="https://ep.gov.pk/track.asp" target="_blank" class="alert-link">
                            Pakistan Post tracking system <i class="fas fa-external-link-alt ms-1"></i>
                        </a>
                    </div>

                    <form action="{{ route('admin.update-tracking-ids') }}" method="POST">
                        @csrf
                        
                        @foreach($orders as $order)
                            <input type="hidden" name="order_ids[]" value="{{ $order->id }}">
                        @endforeach

                        <div class="row">
                            @foreach($orders as $index => $order)
                                <div class="col-md-6 mb-4">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0">
                                                <i class="fas fa-receipt me-2"></i>
                                                Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-2">
                                                <strong>Customer:</strong> {{ $order->name }}<br>
                                                <strong>Phone:</strong> {{ $order->phone_number }}<br>
                                                <strong>Address:</strong> {{ Str::limit($order->full_address, 50) }}<br>
                                                <strong>City:</strong> {{ $order->city }}, {{ $order->country }}
                                            </div>
                                            
                                            <div class="mb-2">
                                                <strong>Semesters:</strong>
                                                @foreach($order->semesters as $semester)
                                                    <span class="badge bg-secondary me-1">{{ $semester }}</span>
                                                @endforeach
                                            </div>

                                            <div class="form-group">
                                                <label for="tracking_id_{{ $index }}" class="form-label">
                                                    <i class="fas fa-barcode me-1"></i>
                                                    <strong>Tracking ID *</strong>
                                                </label>
                                                <input type="text" 
                                                       class="form-control" 
                                                       id="tracking_id_{{ $index }}" 
                                                       name="tracking_ids[]" 
                                                       placeholder="Enter Pakistan Post tracking ID"
                                                       required>
                                                <small class="form-text text-muted">
                                                    Enter the tracking ID from Pakistan Post for this order
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                                    </a>
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-check me-2"></i>
                                        Dispatch {{ count($orders) }} Order(s) with Tracking IDs
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>

<script>
    // Auto-focus first input
    document.addEventListener('DOMContentLoaded', function() {
        const firstInput = document.querySelector('input[name="tracking_ids[]"]');
        if (firstInput) {
            firstInput.focus();
        }
        
        // Add Enter key navigation
        const trackingInputs = document.querySelectorAll('input[name="tracking_ids[]"]');
        trackingInputs.forEach((input, index) => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const nextInput = trackingInputs[index + 1];
                    if (nextInput) {
                        nextInput.focus();
                    } else {
                        // Focus submit button if it's the last input
                        document.querySelector('button[type="submit"]').focus();
                    }
                }
            });
        });
    });
</script>
@endsection
