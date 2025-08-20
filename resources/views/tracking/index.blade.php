@extends('layouts.app')

@section('title', 'Track Your Order - SSA Technology')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h1><i class="fas fa-search me-3"></i>Track Your Order</h1>
                    <p class="mb-0 mt-2 opacity-90">Enter your details to track your semester notes order</p>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('tracking.track') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Full Name *
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       placeholder="Enter your full name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Phone Number *
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" 
                                       name="phone_number" 
                                       value="{{ old('phone_number') }}" 
                                       placeholder="Enter your phone number"
                                       required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Track My Orders
                            </button>
                        </div>
                        
                        <div class="text-center">
                            <p class="text-muted mb-3">
                                <i class="fas fa-info-circle me-1"></i>
                                Enter the same name and phone number you used when placing your order
                            </p>
                            
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ route('user.order-form') }}" class="btn btn-outline-success">
                                    <i class="fas fa-plus me-1"></i>Place New Order
                                </a>
                                <a href="{{ route('admin.login') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-shield-alt me-1"></i>Admin Login
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Features Section -->
            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Fast Delivery</h5>
                            <p class="card-text">Quick and reliable delivery of your semester notes to your doorstep.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-book-open fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">Quality Notes</h5>
                            <p class="card-text">High-quality, comprehensive semester notes for all your academic needs.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class="fas fa-headset fa-3x text-info"></i>
                            </div>
                            <h5 class="card-title">24/7 Support</h5>
                            <p class="card-text">Round-the-clock customer support for all your queries and concerns.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .fa-3x {
        transition: color 0.3s ease;
    }
    
    .card:hover .fa-3x {
        opacity: 0.8;
    }
</style>
@endsection
