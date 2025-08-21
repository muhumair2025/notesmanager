<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Semester Notes - Notes Order Manager</title>
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
            max-width: 700px;
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
        
        .form-control, .form-select, .btn {
            border-radius: 6px;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
        
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            font-weight: 500;
        }
        
        .btn-outline-secondary {
            font-weight: 500;
        }
        
        .alert {
            border-radius: 6px;
            border: none;
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
            color: #721c24;
        }
        
        .navbar-brand {
            font-weight: 600;
            color: #0d6efd !important;
        }
        
        .form-section {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .form-section h6 {
            color: #495057;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .semester-checkbox {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: white;
            transition: all 0.2s ease;
        }
        
        .semester-checkbox:hover {
            background-color: #f8f9fa;
        }
        
        .semester-checkbox input:checked + label {
            color: #0d6efd;
            font-weight: 500;
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
            
            .form-section {
                padding: 0.75rem;
            }
        }
        
        @media (max-width: 576px) {
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
            <a href="{{ route('tracking.index') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-search me-1"></i>Track Order
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <div class="main-card">
            <div class="card-header">
                <h1 class="h3 mb-2">
                    <i class="fas fa-book text-primary me-2"></i>Order Semester Notes
                </h1>
                <p class="text-muted mb-0">Fill out the form below to place your order</p>
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Shukria, Ap Ka Form Kamyabi Sy Fill Ho Gia Hai, Ab Aap Kuch Din ( 1 sy 3 Hafty) Wait Karyn, Jald Hee Notes Print Ho Kar Apko Ponch Jayengy, Apna Dia Gia Number Open Rakhyn, Aor Active, Kionky Baz Dafa Post Office Waly Call Na Othany Ki Surat Me Notes Wapis Hamy Bhej Dety Hen.
                        @if(session('show_track_button') && session('order_id'))
                            <div class="mt-3 p-3 bg-white border rounded">
                                <strong class="text-success">Your Order ID: #{{ str_pad(session('order_id'), 4, '0', STR_PAD_LEFT) }}</strong>
                                <br>
                                <small class="text-muted">Save this ID for tracking your order</small>
                                <div class="mt-2">
                                    <a href="{{ route('tracking.index') }}" class="btn btn-success btn-sm me-2">
                                        <i class="fas fa-search me-2"></i>Track Your Order
                                    </a>
                                    @if(old('phone_number'))
                                        <a href="{{ route('user.order-history', old('phone_number')) }}" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-history me-1"></i>My Orders
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

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

                <form action="{{ route('user.store') }}" method="POST" id="orderForm">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h6><i class="fas fa-user me-2"></i>Personal Information</h6>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name *</label>
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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">Phone Number *</label>
                                <input type="tel" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" 
                                       name="phone_number" 
                                       value="{{ old('phone_number') }}" 
                                       placeholder="03xxxxxxxxx"
                                       required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="secondary_phone_number" class="form-label">Secondary Phone (Optional)</label>
                                <input type="tel" 
                                       class="form-control @error('secondary_phone_number') is-invalid @enderror" 
                                       id="secondary_phone_number" 
                                       name="secondary_phone_number" 
                                       value="{{ old('secondary_phone_number') }}"
                                       placeholder="Alternative contact">
                                @error('secondary_phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <!-- Address Information -->
                    <div class="form-section">
                        <h6><i class="fas fa-map-marker-alt me-2"></i>Delivery Address</h6>
                        
                        <div class="mb-3">
                            <label for="full_address" class="form-label">Complete Address *</label>
                            <textarea class="form-control @error('full_address') is-invalid @enderror" 
                                      id="full_address" 
                                      name="full_address" 
                                      rows="3"
                                      placeholder="House/Flat #, Street, Area, Landmark"
                                      required>{{ old('full_address') }}</textarea>
                            @error('full_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city') }}" 
                                       placeholder="Enter your city"
                                       required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <select class="form-select @error('country') is-invalid @enderror" 
                                        id="country" 
                                        name="country" 
                                        required>
                                    <option value="">Select Country</option>
                                    <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                    <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                    <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="form-section">
                        <h6><i class="fas fa-graduation-cap me-2"></i>Select Semesters *</h6>
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            یہاں وہ سمسٹر منتخب کریں جس کے آپ کو نوٹس چاہیے، آپ ایک سے زیادہ سمسٹرز بھی منتخب کر سکتے ہیں
                        </div>
                        
                        <div class="row">
                            @php
                                $semesters = [
                                    'sem 1 notes' => '1st Semester',
                                    'sem 2 notes' => '2nd Semester', 
                                    'sem 3 notes' => '3rd Semester',
                                    'sem 4 notes' => '4th Semester',
                                    'sem 5 notes' => '5th Semester',
                                    'sem 6 notes' => '6th Semester',
                                    'sem 7 notes' => '7th Semester'
                                ];
                                $oldSemesters = old('semesters', []);
                            @endphp
                            
                            @foreach($semesters as $value => $label)
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="semester-checkbox">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="semesters[]" 
                                                   value="{{ $value }}" 
                                                   id="semester_{{ $loop->index }}"
                                                   {{ in_array($value, $oldSemesters) ? 'checked' : '' }}>
                                            <label class="form-check-label w-100" for="semester_{{ $loop->index }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @error('semesters')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fee Payment Status -->
                    <div class="form-section">
                        <h6><i class="fas fa-money-bill-wave me-2"></i>Fee Payment Status</h6>
                        
                        <div class="mb-3">
                            <label class="form-label">کیا آپ نے فیس ادا کی ہے؟ *</label>
                            <div class="mt-2">
                                <div class="form-check mb-2">
                                    <input class="form-check-input @error('fees_paid') is-invalid @enderror" 
                                           type="radio" 
                                           name="fees_paid" 
                                           id="fees_paid_yes" 
                                           value="1" 
                                           {{ old('fees_paid') == '1' ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label" for="fees_paid_yes">
                                        ہاں، میں نے فیس ادا کی ہے
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('fees_paid') is-invalid @enderror" 
                                           type="radio" 
                                           name="fees_paid" 
                                           id="fees_paid_no" 
                                           value="0" 
                                           {{ old('fees_paid') == '0' ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label" for="fees_paid_no">
                                        نہیں، میں نے ابھی فیس ادا نہیں کی
                                    </label>
                                </div>
                                @error('fees_paid')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="form-section">
                        <h6><i class="fas fa-comment me-2"></i>Additional Information</h6>
                        
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Special Instructions (Optional)</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" 
                                      name="remarks" 
                                      rows="3"
                                      placeholder="Any special delivery instructions or notes">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                            <i class="fas fa-shopping-cart me-2"></i>Place Order
                        </button>
                    </div>
                    
                    <div class="text-center">
                        <div class="d-flex justify-content-center gap-2 btn-group-mobile">
                            <a href="{{ route('tracking.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Tracking
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('orderForm');
            const submitBtn = document.getElementById('submitBtn');
            const STORAGE_KEY = 'notesOrderForm_autoSave';
            
            // Form Auto-save functionality
            const formInputs = form.querySelectorAll('input, textarea, select');
            let autoSaveTimeout;
            
            // Load saved data on page load
            loadSavedData();
            
            // Add auto-save listeners to all form inputs
            formInputs.forEach(input => {
                input.addEventListener('input', debounceAutoSave);
                input.addEventListener('change', debounceAutoSave);
            });
            
            function debounceAutoSave() {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(saveFormData, 1000); // Save after 1 second of inactivity
            }
            
            function saveFormData() {
                try {
                    const formData = new FormData(form);
                    const data = {};
                    
                    // Save regular inputs
                    for (let [key, value] of formData.entries()) {
                        if (key === 'semesters[]') {
                            if (!data.semesters) data.semesters = [];
                            data.semesters.push(value);
                        } else if (key !== '_token') { // Don't save CSRF token
                            data[key] = value;
                        }
                    }
                    
                    // Save radio button states
                    const feesPaidRadio = form.querySelector('input[name="fees_paid"]:checked');
                    if (feesPaidRadio) {
                        data.fees_paid = feesPaidRadio.value;
                    }
                    
                    localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
                    
                    // Show auto-save indicator
                    showAutoSaveIndicator();
                } catch (error) {
                    console.warn('Auto-save failed:', error);
                }
            }
            
            function loadSavedData() {
                try {
                    const savedData = localStorage.getItem(STORAGE_KEY);
                    if (!savedData) return;
                    
                    const data = JSON.parse(savedData);
                    
                    // Load regular inputs
                    Object.keys(data).forEach(key => {
                        if (key === 'semesters') {
                            // Load semester checkboxes
                            data.semesters.forEach(semester => {
                                const checkbox = form.querySelector(`input[name="semesters[]"][value="${semester}"]`);
                                if (checkbox) checkbox.checked = true;
                            });
                        } else if (key === 'fees_paid') {
                            // Load radio button
                            const radio = form.querySelector(`input[name="fees_paid"][value="${data[key]}"]`);
                            if (radio) radio.checked = true;
                        } else {
                            // Load other inputs
                            const input = form.querySelector(`[name="${key}"]`);
                            if (input) input.value = data[key];
                        }
                    });
                    
                    // Show restored data indicator
                    showRestoredDataIndicator();
                } catch (error) {
                    console.warn('Failed to load saved data:', error);
                }
            }
            
            function showAutoSaveIndicator() {
                // Create or update auto-save indicator
                let indicator = document.getElementById('autoSaveIndicator');
                if (!indicator) {
                    indicator = document.createElement('div');
                    indicator.id = 'autoSaveIndicator';
                    indicator.className = 'position-fixed bg-success text-white px-3 py-2 rounded';
                    indicator.style.cssText = 'top: 20px; right: 20px; z-index: 9999; font-size: 0.8rem; opacity: 0; transition: opacity 0.3s;';
                    document.body.appendChild(indicator);
                }
                
                indicator.innerHTML = '<i class="fas fa-check me-1"></i>Form auto-saved';
                indicator.style.opacity = '1';
                
                setTimeout(() => {
                    indicator.style.opacity = '0';
                }, 2000);
            }
            
            function showRestoredDataIndicator() {
                const indicator = document.createElement('div');
                indicator.className = 'alert alert-info alert-dismissible fade show mt-3';
                indicator.innerHTML = `
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Form data restored!</strong> Your previously entered information has been recovered.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearSavedData()">
                            <i class="fas fa-trash me-1"></i>Clear Saved Data
                        </button>
                    </div>
                `;
                
                const cardBody = document.querySelector('.card-body');
                cardBody.insertBefore(indicator, cardBody.firstChild);
            }
            
            // Clear saved data function (global scope for button onclick)
            window.clearSavedData = function() {
                localStorage.removeItem(STORAGE_KEY);
                location.reload();
            };
            
            // Form validation and submission
            form.addEventListener('submit', function(e) {
                const checkedSemesters = form.querySelectorAll('input[name="semesters[]"]:checked');
                
                if (checkedSemesters.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one semester.');
                    return;
                }
                
                // Clear saved data on successful submission
                localStorage.removeItem(STORAGE_KEY);
                
                // Show loading state
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                submitBtn.disabled = true;
                
                // Re-enable if form submission fails
                setTimeout(() => {
                    if (submitBtn.disabled) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }, 10000);
            });
            
            // Auto-focus on first input for better UX (desktop only)
            const firstInput = document.querySelector('input[name="name"]');
            if (firstInput && window.innerWidth > 768) {
                firstInput.focus();
            }
        });
    </script>
</body>
</html>