<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Order - Notes Order Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        
        .main-card {
            max-width: 500px;
            width: 100%;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background: white;
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
        
        .form-control, .btn {
            border-radius: 6px;
        }
        
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            font-weight: 500;
        }
        
        .btn-outline-success, .btn-outline-secondary {
            font-weight: 500;
        }
        
        .alert {
            border-radius: 6px;
            border: none;
            border-left: 4px solid;
        }
        
        .alert-danger {
            border-left-color: #dc3545;
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #0d6efd !important;
        }
        
        .footer-links {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }
        
        .info-text {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
            
            .card-header, .card-body {
                padding: 1rem;
            }
            
            .btn-group-mobile {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .btn-group-mobile .btn {
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

        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-card" style="margin-top: 70px;">
        <div class="card-header">
            <h1 class="h3 mb-2">
                <i class="fas fa-search text-primary me-2"></i>Track Your Order
            </h1>
            <p class="text-muted mb-0">Enter your details to find your semester notes order</p>
        </div>
        
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @if($errors->has('rate_limit'))
                        <strong>Rate Limit Exceeded:</strong>
                        <div class="mt-2">{{ $errors->first('rate_limit') }}</div>
                    @else
                        <strong>Please fix the following:</strong>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            <form action="{{ route('tracking.track') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-1 text-muted"></i>Full Name
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
                
                <div class="mb-3">
                    <label for="phone_number" class="form-label">
                        <i class="fas fa-phone me-1 text-muted"></i>Phone Number
                    </label>
                    <input type="tel" 
                           class="form-control @error('phone_number') is-invalid @enderror" 
                           id="phone_number" 
                           name="phone_number" 
                           value="{{ old('phone_number') }}" 
                           placeholder="e.g., 03001234567 or +923001234567"
                           required>
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="info-text">
                    <i class="fas fa-info-circle me-1"></i>
                    <strong>Important:</strong> Use the same name and phone number from your order. You can enter the phone number with or without country code (e.g., 03001234567 or +923001234567).
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Track My Orders
                    </button>
                </div>
            </form>
            
            <div class="footer-links">
                <div class="d-flex justify-content-center gap-2 flex-wrap btn-group-mobile">
                    <a href="{{ route('user.order-form') }}" class="btn btn-outline-success">
                        <i class="fas fa-plus me-1"></i>Place New Order
                    </a>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-focus on first input for better UX
        document.addEventListener('DOMContentLoaded', function() {
            const firstInput = document.querySelector('input[name="name"]');
            if (firstInput && window.innerWidth > 768) {
                firstInput.focus();
            }
        });

        // Form validation enhancement
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Searching...';
            submitBtn.disabled = true;
            
            // Re-enable if form submission fails
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 5000);
        });
    </script>
</body>
</html>