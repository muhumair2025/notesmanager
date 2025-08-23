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
         
         /* Phone number with country code styles */
         .phone-input-group {
             display: flex;
             align-items: stretch;
         }
         
                   .country-code-select {
              flex: 0 0 auto;
              border-top-right-radius: 0;
              border-bottom-right-radius: 0;
              border-right: none;
              min-width: 80px;
              max-width: 100px;
          }
         
         .phone-number-input {
             border-top-left-radius: 0;
             border-bottom-left-radius: 0;
             flex: 1;
         }
         
         .phone-input-group .form-control:focus {
             z-index: 1;
         }
         
         .country-code-select:focus {
             z-index: 2;
         }
         
         @media (max-width: 576px) {
             .phone-input-group {
                 flex-direction: column;
             }
             
             .country-code-select {
                 border-radius: 6px 6px 0 0;
                 border-right: 1px solid #dee2e6;
                 border-bottom: none;
                 min-width: auto;
             }
             
             .phone-number-input {
                 border-radius: 0 0 6px 6px;
                 border-top-left-radius: 0;
                 border-top-right-radius: 0;
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
                        @elseif($errors->has('semester_duplicate'))
                            <strong>Duplicate Order Detected:</strong>
                            <div class="mt-2">{{ $errors->first('semester_duplicate') }}</div>
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
                                 <div class="phone-input-group">
                                     <select class="form-select country-code-select @error('phone_country_code') is-invalid @enderror" 
                                             id="phone_country_code" 
                                             name="phone_country_code" 
                                             required>
                                                                                   <option value="">Code</option>
                                                                                   <option value="+92" {{ old('phone_country_code') == '+92' ? 'selected' : '' }}>🇵🇰 +92 (Pakistan)</option>
    <option value="+91" {{ old('phone_country_code') == '+91' ? 'selected' : '' }}>🇮🇳 +91 (India)</option>
    <option value="+880" {{ old('phone_country_code') == '+880' ? 'selected' : '' }}>🇧🇩 +880 (Bangladesh)</option>
    <option value="+1" {{ old('phone_country_code') == '+1' ? 'selected' : '' }}>🇺🇸 +1 (USA/Canada)</option>
    <option value="+44" {{ old('phone_country_code') == '+44' ? 'selected' : '' }}>🇬🇧 +44 (UK)</option>
    <option value="+971" {{ old('phone_country_code') == '+971' ? 'selected' : '' }}>🇦🇪 +971 (UAE)</option>
    <option value="+966" {{ old('phone_country_code') == '+966' ? 'selected' : '' }}>🇸🇦 +966 (Saudi Arabia)</option>
    <option value="+974" {{ old('phone_country_code') == '+974' ? 'selected' : '' }}>🇶🇦 +974 (Qatar)</option>
    <option value="+973" {{ old('phone_country_code') == '+973' ? 'selected' : '' }}>🇧🇭 +973 (Bahrain)</option>
    <option value="+965" {{ old('phone_country_code') == '+965' ? 'selected' : '' }}>🇰🇼 +965 (Kuwait)</option>
    <option value="+968" {{ old('phone_country_code') == '+968' ? 'selected' : '' }}>🇴🇲 +968 (Oman)</option>

    <!-- More countries -->
    <option value="+93" {{ old('phone_country_code') == '+93' ? 'selected' : '' }}>🇦🇫 +93 (Afghanistan)</option>
    <option value="+355" {{ old('phone_country_code') == '+355' ? 'selected' : '' }}>🇦🇱 +355 (Albania)</option>
    <option value="+213" {{ old('phone_country_code') == '+213' ? 'selected' : '' }}>🇩🇿 +213 (Algeria)</option>
    <option value="+376" {{ old('phone_country_code') == '+376' ? 'selected' : '' }}>🇦🇩 +376 (Andorra)</option>
    <option value="+244" {{ old('phone_country_code') == '+244' ? 'selected' : '' }}>🇦🇴 +244 (Angola)</option>
    <option value="+54" {{ old('phone_country_code') == '+54' ? 'selected' : '' }}>🇦🇷 +54 (Argentina)</option>
    <option value="+374" {{ old('phone_country_code') == '+374' ? 'selected' : '' }}>🇦🇲 +374 (Armenia)</option>
    <option value="+61" {{ old('phone_country_code') == '+61' ? 'selected' : '' }}>🇦🇺 +61 (Australia)</option>
    <option value="+43" {{ old('phone_country_code') == '+43' ? 'selected' : '' }}>🇦🇹 +43 (Austria)</option>
    <option value="+994" {{ old('phone_country_code') == '+994' ? 'selected' : '' }}>🇦🇿 +994 (Azerbaijan)</option>
    <option value="+32" {{ old('phone_country_code') == '+32' ? 'selected' : '' }}>🇧🇪 +32 (Belgium)</option>
    <option value="+229" {{ old('phone_country_code') == '+229' ? 'selected' : '' }}>🇧🇯 +229 (Benin)</option>
    <option value="+975" {{ old('phone_country_code') == '+975' ? 'selected' : '' }}>🇧🇹 +975 (Bhutan)</option>
    <option value="+55" {{ old('phone_country_code') == '+55' ? 'selected' : '' }}>🇧🇷 +55 (Brazil)</option>
    <option value="+359" {{ old('phone_country_code') == '+359' ? 'selected' : '' }}>🇧🇬 +359 (Bulgaria)</option>
    <option value="+855" {{ old('phone_country_code') == '+855' ? 'selected' : '' }}>🇰🇭 +855 (Cambodia)</option>
    <option value="+237" {{ old('phone_country_code') == '+237' ? 'selected' : '' }}>🇨🇲 +237 (Cameroon)</option>
    <option value="+86" {{ old('phone_country_code') == '+86' ? 'selected' : '' }}>🇨🇳 +86 (China)</option>
    <option value="+57" {{ old('phone_country_code') == '+57' ? 'selected' : '' }}>🇨🇴 +57 (Colombia)</option>
    <option value="+506" {{ old('phone_country_code') == '+506' ? 'selected' : '' }}>🇨🇷 +506 (Costa Rica)</option>
    <option value="+385" {{ old('phone_country_code') == '+385' ? 'selected' : '' }}>🇭🇷 +385 (Croatia)</option>
    <option value="+420" {{ old('phone_country_code') == '+420' ? 'selected' : '' }}>🇨🇿 +420 (Czech Republic)</option>
    <option value="+45" {{ old('phone_country_code') == '+45' ? 'selected' : '' }}>🇩🇰 +45 (Denmark)</option>
    <option value="+20" {{ old('phone_country_code') == '+20' ? 'selected' : '' }}>🇪🇬 +20 (Egypt)</option>
    <option value="+33" {{ old('phone_country_code') == '+33' ? 'selected' : '' }}>🇫🇷 +33 (France)</option>
    <option value="+49" {{ old('phone_country_code') == '+49' ? 'selected' : '' }}>🇩🇪 +49 (Germany)</option>
    <option value="+30" {{ old('phone_country_code') == '+30' ? 'selected' : '' }}>🇬🇷 +30 (Greece)</option>
    <option value="+852" {{ old('phone_country_code') == '+852' ? 'selected' : '' }}>🇭🇰 +852 (Hong Kong)</option>
    <option value="+36" {{ old('phone_country_code') == '+36' ? 'selected' : '' }}>🇭🇺 +36 (Hungary)</option>
    <option value="+62" {{ old('phone_country_code') == '+62' ? 'selected' : '' }}>🇮🇩 +62 (Indonesia)</option>
    <option value="+98" {{ old('phone_country_code') == '+98' ? 'selected' : '' }}>🇮🇷 +98 (Iran)</option>
    <option value="+964" {{ old('phone_country_code') == '+964' ? 'selected' : '' }}>🇮🇶 +964 (Iraq)</option>
    <option value="+39" {{ old('phone_country_code') == '+39' ? 'selected' : '' }}>🇮🇹 +39 (Italy)</option>
    <option value="+81" {{ old('phone_country_code') == '+81' ? 'selected' : '' }}>🇯🇵 +81 (Japan)</option>
    <option value="+962" {{ old('phone_country_code') == '+962' ? 'selected' : '' }}>🇯🇴 +962 (Jordan)</option>
    <option value="+7" {{ old('phone_country_code') == '+7' ? 'selected' : '' }}>🇷🇺 +7 (Russia/Kazakhstan)</option>
    <option value="+254" {{ old('phone_country_code') == '+254' ? 'selected' : '' }}>🇰🇪 +254 (Kenya)</option>
    <option value="+82" {{ old('phone_country_code') == '+82' ? 'selected' : '' }}>🇰🇷 +82 (South Korea)</option>
    <option value="+961" {{ old('phone_country_code') == '+961' ? 'selected' : '' }}>🇱🇧 +961 (Lebanon)</option>
    <option value="+218" {{ old('phone_country_code') == '+218' ? 'selected' : '' }}>🇱🇾 +218 (Libya)</option>
    <option value="+60" {{ old('phone_country_code') == '+60' ? 'selected' : '' }}>🇲🇾 +60 (Malaysia)</option>
    <option value="+212" {{ old('phone_country_code') == '+212' ? 'selected' : '' }}>🇲🇦 +212 (Morocco)</option>
    <option value="+977" {{ old('phone_country_code') == '+977' ? 'selected' : '' }}>🇳🇵 +977 (Nepal)</option>
    <option value="+31" {{ old('phone_country_code') == '+31' ? 'selected' : '' }}>🇳🇱 +31 (Netherlands)</option>
    <option value="+234" {{ old('phone_country_code') == '+234' ? 'selected' : '' }}>🇳🇬 +234 (Nigeria)</option>
    <option value="+47" {{ old('phone_country_code') == '+47' ? 'selected' : '' }}>🇳🇴 +47 (Norway)</option>
    <option value="+92" {{ old('phone_country_code') == '+92' ? 'selected' : '' }}>🇵🇰 +92 (Pakistan)</option>
    <option value="+51" {{ old('phone_country_code') == '+51' ? 'selected' : '' }}>🇵🇪 +51 (Peru)</option>
    <option value="+63" {{ old('phone_country_code') == '+63' ? 'selected' : '' }}>🇵🇭 +63 (Philippines)</option>
    <option value="+48" {{ old('phone_country_code') == '+48' ? 'selected' : '' }}>🇵🇱 +48 (Poland)</option>
    <option value="+351" {{ old('phone_country_code') == '+351' ? 'selected' : '' }}>🇵🇹 +351 (Portugal)</option>
    <option value="+7" {{ old('phone_country_code') == '+7' ? 'selected' : '' }}>🇷🇺 +7 (Russia)</option>
    <option value="+65" {{ old('phone_country_code') == '+65' ? 'selected' : '' }}>🇸🇬 +65 (Singapore)</option>
    <option value="+27" {{ old('phone_country_code') == '+27' ? 'selected' : '' }}>🇿🇦 +27 (South Africa)</option>
    <option value="+34" {{ old('phone_country_code') == '+34' ? 'selected' : '' }}>🇪🇸 +34 (Spain)</option>
    <option value="+94" {{ old('phone_country_code') == '+94' ? 'selected' : '' }}>🇱🇰 +94 (Sri Lanka)</option>
    <option value="+46" {{ old('phone_country_code') == '+46' ? 'selected' : '' }}>🇸🇪 +46 (Sweden)</option>
    <option value="+41" {{ old('phone_country_code') == '+41' ? 'selected' : '' }}>🇨🇭 +41 (Switzerland)</option>
    <option value="+66" {{ old('phone_country_code') == '+66' ? 'selected' : '' }}>🇹🇭 +66 (Thailand)</option>
    <option value="+90" {{ old('phone_country_code') == '+90' ? 'selected' : '' }}>🇹🇷 +90 (Turkey)</option>
    <option value="+256" {{ old('phone_country_code') == '+256' ? 'selected' : '' }}>🇺🇬 +256 (Uganda)</option>
    <option value="+380" {{ old('phone_country_code') == '+380' ? 'selected' : '' }}>🇺🇦 +380 (Ukraine)</option>
    <option value="+598" {{ old('phone_country_code') == '+598' ? 'selected' : '' }}>🇺🇾 +598 (Uruguay)</option>
    <option value="+998" {{ old('phone_country_code') == '+998' ? 'selected' : '' }}>🇺🇿 +998 (Uzbekistan)</option>
    <option value="+58" {{ old('phone_country_code') == '+58' ? 'selected' : '' }}>🇻🇪 +58 (Venezuela)</option>
    <option value="+84" {{ old('phone_country_code') == '+84' ? 'selected' : '' }}>🇻🇳 +84 (Vietnam)</option>
    <option value="+967" {{ old('phone_country_code') == '+967' ? 'selected' : '' }}>🇾🇪 +967 (Yemen)</option>
                                     </select>
                                     <input type="tel" 
                                            class="form-control phone-number-input @error('phone_number') is-invalid @enderror" 
                                            id="phone_number" 
                                            name="phone_number" 
                                            value="{{ old('phone_number') }}" 
                                            placeholder="3xxxxxxxxx"
                                            required>
                                 </div>
                                 @error('phone_country_code')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                                 @error('phone_number')
                                     <div class="invalid-feedback">{{ $message }}</div>
                                 @enderror
                             </div>
                            
                                                         <div class="col-md-6 mb-3">
                                 <label for="secondary_phone_number" class="form-label">Secondary Phone (Optional)</label>
                                 <div class="phone-input-group">
                                     <select class="form-select country-code-select" 
                                             id="secondary_phone_country_code" 
                                             name="secondary_phone_country_code">
                                                                                   <option value="">Code</option>
                                                                                   <option value="+92" {{ old('secondary_phone_country_code') == '+92' ? 'selected' : '' }}>🇵🇰 +92 (Pakistan)</option>
    <option value="+91" {{ old('secondary_phone_country_code') == '+91' ? 'selected' : '' }}>🇮🇳 +91 (India)</option>
    <option value="+880" {{ old('secondary_phone_country_code') == '+880' ? 'selected' : '' }}>🇧🇩 +880 (Bangladesh)</option>
    <option value="+1" {{ old('secondary_phone_country_code') == '+1' ? 'selected' : '' }}>🇺🇸 +1 (USA/Canada)</option>
    <option value="+44" {{ old('secondary_phone_country_code') == '+44' ? 'selected' : '' }}>🇬🇧 +44 (UK)</option>
    <option value="+971" {{ old('secondary_phone_country_code') == '+971' ? 'selected' : '' }}>🇦🇪 +971 (UAE)</option>
    <option value="+966" {{ old('secondary_phone_country_code') == '+966' ? 'selected' : '' }}>🇸🇦 +966 (Saudi Arabia)</option>
    <option value="+974" {{ old('secondary_phone_country_code') == '+974' ? 'selected' : '' }}>🇶🇦 +974 (Qatar)</option>
    <option value="+973" {{ old('secondary_phone_country_code') == '+973' ? 'selected' : '' }}>🇧🇭 +973 (Bahrain)</option>
    <option value="+965" {{ old('secondary_phone_country_code') == '+965' ? 'selected' : '' }}>🇰🇼 +965 (Kuwait)</option>
    <option value="+968" {{ old('secondary_phone_country_code') == '+968' ? 'selected' : '' }}>🇴🇲 +968 (Oman)</option>

    <!-- More countries -->
    <option value="+93" {{ old('secondary_phone_country_code') == '+93' ? 'selected' : '' }}>🇦🇫 +93 (Afghanistan)</option>
    <option value="+355" {{ old('secondary_phone_country_code') == '+355' ? 'selected' : '' }}>🇦🇱 +355 (Albania)</option>
    <option value="+213" {{ old('secondary_phone_country_code') == '+213' ? 'selected' : '' }}>🇩🇿 +213 (Algeria)</option>
    <option value="+376" {{ old('secondary_phone_country_code') == '+376' ? 'selected' : '' }}>🇦🇩 +376 (Andorra)</option>
    <option value="+244" {{ old('secondary_phone_country_code') == '+244' ? 'selected' : '' }}>🇦🇴 +244 (Angola)</option>
    <option value="+54" {{ old('secondary_phone_country_code') == '+54' ? 'selected' : '' }}>🇦🇷 +54 (Argentina)</option>
    <option value="+374" {{ old('secondary_phone_country_code') == '+374' ? 'selected' : '' }}>🇦🇲 +374 (Armenia)</option>
    <option value="+61" {{ old('secondary_phone_country_code') == '+61' ? 'selected' : '' }}>🇦🇺 +61 (Australia)</option>
    <option value="+43" {{ old('secondary_phone_country_code') == '+43' ? 'selected' : '' }}>🇦🇹 +43 (Austria)</option>
    <option value="+994" {{ old('secondary_phone_country_code') == '+994' ? 'selected' : '' }}>🇦🇿 +994 (Azerbaijan)</option>
    <option value="+32" {{ old('secondary_phone_country_code') == '+32' ? 'selected' : '' }}>🇧🇪 +32 (Belgium)</option>
    <option value="+229" {{ old('secondary_phone_country_code') == '+229' ? 'selected' : '' }}>🇧🇯 +229 (Benin)</option>
    <option value="+975" {{ old('secondary_phone_country_code') == '+975' ? 'selected' : '' }}>🇧🇹 +975 (Bhutan)</option>
    <option value="+55" {{ old('secondary_phone_country_code') == '+55' ? 'selected' : '' }}>🇧🇷 +55 (Brazil)</option>
    <option value="+359" {{ old('secondary_phone_country_code') == '+359' ? 'selected' : '' }}>🇧🇬 +359 (Bulgaria)</option>
    <option value="+855" {{ old('secondary_phone_country_code') == '+855' ? 'selected' : '' }}>🇰🇭 +855 (Cambodia)</option>
    <option value="+237" {{ old('secondary_phone_country_code') == '+237' ? 'selected' : '' }}>🇨🇲 +237 (Cameroon)</option>
    <option value="+86" {{ old('secondary_phone_country_code') == '+86' ? 'selected' : '' }}>🇨🇳 +86 (China)</option>
    <option value="+57" {{ old('secondary_phone_country_code') == '+57' ? 'selected' : '' }}>🇨🇴 +57 (Colombia)</option>
    <option value="+506" {{ old('secondary_phone_country_code') == '+506' ? 'selected' : '' }}>🇨🇷 +506 (Costa Rica)</option>
    <option value="+385" {{ old('secondary_phone_country_code') == '+385' ? 'selected' : '' }}>🇭🇷 +385 (Croatia)</option>
    <option value="+420" {{ old('secondary_phone_country_code') == '+420' ? 'selected' : '' }}>🇨🇿 +420 (Czech Republic)</option>
    <option value="+45" {{ old('secondary_phone_country_code') == '+45' ? 'selected' : '' }}>🇩🇰 +45 (Denmark)</option>
    <option value="+20" {{ old('secondary_phone_country_code') == '+20' ? 'selected' : '' }}>🇪🇬 +20 (Egypt)</option>
    <option value="+33" {{ old('secondary_phone_country_code') == '+33' ? 'selected' : '' }}>🇫🇷 +33 (France)</option>
    <option value="+49" {{ old('secondary_phone_country_code') == '+49' ? 'selected' : '' }}>🇩🇪 +49 (Germany)</option>
    <option value="+30" {{ old('secondary_phone_country_code') == '+30' ? 'selected' : '' }}>🇬🇷 +30 (Greece)</option>
    <option value="+852" {{ old('secondary_phone_country_code') == '+852' ? 'selected' : '' }}>🇭🇰 +852 (Hong Kong)</option>
    <option value="+36" {{ old('secondary_phone_country_code') == '+36' ? 'selected' : '' }}>🇭🇺 +36 (Hungary)</option>
    <option value="+62" {{ old('secondary_phone_country_code') == '+62' ? 'selected' : '' }}>🇮🇩 +62 (Indonesia)</option>
    <option value="+98" {{ old('secondary_phone_country_code') == '+98' ? 'selected' : '' }}>🇮🇷 +98 (Iran)</option>
    <option value="+964" {{ old('secondary_phone_country_code') == '+964' ? 'selected' : '' }}>🇮🇶 +964 (Iraq)</option>
    <option value="+39" {{ old('secondary_phone_country_code') == '+39' ? 'selected' : '' }}>🇮🇹 +39 (Italy)</option>
    <option value="+81" {{ old('secondary_phone_country_code') == '+81' ? 'selected' : '' }}>🇯🇵 +81 (Japan)</option>
    <option value="+962" {{ old('secondary_phone_country_code') == '+962' ? 'selected' : '' }}>🇯🇴 +962 (Jordan)</option>
    <option value="+7" {{ old('secondary_phone_country_code') == '+7' ? 'selected' : '' }}>🇷🇺 +7 (Russia/Kazakhstan)</option>
    <option value="+254" {{ old('secondary_phone_country_code') == '+254' ? 'selected' : '' }}>🇰🇪 +254 (Kenya)</option>
    <option value="+82" {{ old('secondary_phone_country_code') == '+82' ? 'selected' : '' }}>🇰🇷 +82 (South Korea)</option>
    <option value="+961" {{ old('secondary_phone_country_code') == '+961' ? 'selected' : '' }}>🇱🇧 +961 (Lebanon)</option>
    <option value="+218" {{ old('secondary_phone_country_code') == '+218' ? 'selected' : '' }}>🇱🇾 +218 (Libya)</option>
    <option value="+60" {{ old('secondary_phone_country_code') == '+60' ? 'selected' : '' }}>🇲🇾 +60 (Malaysia)</option>
    <option value="+212" {{ old('secondary_phone_country_code') == '+212' ? 'selected' : '' }}>🇲🇦 +212 (Morocco)</option>
    <option value="+977" {{ old('secondary_phone_country_code') == '+977' ? 'selected' : '' }}>🇳🇵 +977 (Nepal)</option>
    <option value="+31" {{ old('secondary_phone_country_code') == '+31' ? 'selected' : '' }}>🇳🇱 +31 (Netherlands)</option>
    <option value="+234" {{ old('secondary_phone_country_code') == '+234' ? 'selected' : '' }}>🇳🇬 +234 (Nigeria)</option>
    <option value="+47" {{ old('secondary_phone_country_code') == '+47' ? 'selected' : '' }}>🇳🇴 +47 (Norway)</option>
    <option value="+51" {{ old('secondary_phone_country_code') == '+51' ? 'selected' : '' }}>🇵🇪 +51 (Peru)</option>
    <option value="+63" {{ old('secondary_phone_country_code') == '+63' ? 'selected' : '' }}>🇵🇭 +63 (Philippines)</option>
    <option value="+48" {{ old('secondary_phone_country_code') == '+48' ? 'selected' : '' }}>🇵🇱 +48 (Poland)</option>
    <option value="+351" {{ old('secondary_phone_country_code') == '+351' ? 'selected' : '' }}>🇵🇹 +351 (Portugal)</option>
    <option value="+65" {{ old('secondary_phone_country_code') == '+65' ? 'selected' : '' }}>🇸🇬 +65 (Singapore)</option>
    <option value="+27" {{ old('secondary_phone_country_code') == '+27' ? 'selected' : '' }}>🇿🇦 +27 (South Africa)</option>
    <option value="+34" {{ old('secondary_phone_country_code') == '+34' ? 'selected' : '' }}>🇪🇸 +34 (Spain)</option>
    <option value="+94" {{ old('secondary_phone_country_code') == '+94' ? 'selected' : '' }}>🇱🇰 +94 (Sri Lanka)</option>
    <option value="+46" {{ old('secondary_phone_country_code') == '+46' ? 'selected' : '' }}>🇸🇪 +46 (Sweden)</option>
    <option value="+41" {{ old('secondary_phone_country_code') == '+41' ? 'selected' : '' }}>🇨🇭 +41 (Switzerland)</option>
    <option value="+66" {{ old('secondary_phone_country_code') == '+66' ? 'selected' : '' }}>🇹🇭 +66 (Thailand)</option>
    <option value="+90" {{ old('secondary_phone_country_code') == '+90' ? 'selected' : '' }}>🇹🇷 +90 (Turkey)</option>
    <option value="+256" {{ old('secondary_phone_country_code') == '+256' ? 'selected' : '' }}>🇺🇬 +256 (Uganda)</option>
    <option value="+380" {{ old('secondary_phone_country_code') == '+380' ? 'selected' : '' }}>🇺🇦 +380 (Ukraine)</option>
    <option value="+598" {{ old('secondary_phone_country_code') == '+598' ? 'selected' : '' }}>🇺🇾 +598 (Uruguay)</option>
    <option value="+998" {{ old('secondary_phone_country_code') == '+998' ? 'selected' : '' }}>🇺🇿 +998 (Uzbekistan)</option>
    <option value="+58" {{ old('secondary_phone_country_code') == '+58' ? 'selected' : '' }}>🇻🇪 +58 (Venezuela)</option>
    <option value="+84" {{ old('secondary_phone_country_code') == '+84' ? 'selected' : '' }}>🇻🇳 +84 (Vietnam)</option>
    <option value="+967" {{ old('secondary_phone_country_code') == '+967' ? 'selected' : '' }}>🇾🇪 +967 (Yemen)</option>
                                     </select>
                                     <input type="tel" 
                                            class="form-control phone-number-input @error('secondary_phone_number') is-invalid @enderror" 
                                            id="secondary_phone_number" 
                                            name="secondary_phone_number" 
                                            value="{{ old('secondary_phone_number') }}"
                                            placeholder="Alternative contact">
                                 </div>
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
                                   <!-- Pinned Countries -->
    <option value="Pakistan" {{ old('country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
    <option value="Saudi Arabia" {{ old('country') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
    <option disabled>──────────</option>

    <!-- Full List -->
    <option value="Afghanistan" {{ old('country') == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
    <option value="Albania" {{ old('country') == 'Albania' ? 'selected' : '' }}>Albania</option>
    <option value="Algeria" {{ old('country') == 'Algeria' ? 'selected' : '' }}>Algeria</option>
    <option value="Andorra" {{ old('country') == 'Andorra' ? 'selected' : '' }}>Andorra</option>
    <option value="Angola" {{ old('country') == 'Angola' ? 'selected' : '' }}>Angola</option>
    <option value="Argentina" {{ old('country') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
    <option value="Armenia" {{ old('country') == 'Armenia' ? 'selected' : '' }}>Armenia</option>
    <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
    <option value="Austria" {{ old('country') == 'Austria' ? 'selected' : '' }}>Austria</option>
    <option value="Azerbaijan" {{ old('country') == 'Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
    <option value="Bahrain" {{ old('country') == 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
    <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
    <option value="Belgium" {{ old('country') == 'Belgium' ? 'selected' : '' }}>Belgium</option>
    <option value="Bhutan" {{ old('country') == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
    <option value="Bolivia" {{ old('country') == 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
    <option value="Bosnia and Herzegovina" {{ old('country') == 'Bosnia and Herzegovina' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
    <option value="Brazil" {{ old('country') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
    <option value="Brunei" {{ old('country') == 'Brunei' ? 'selected' : '' }}>Brunei</option>
    <option value="Bulgaria" {{ old('country') == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
    <option value="Cambodia" {{ old('country') == 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
    <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
    <option value="China" {{ old('country') == 'China' ? 'selected' : '' }}>China</option>
    <option value="Colombia" {{ old('country') == 'Colombia' ? 'selected' : '' }}>Colombia</option>
    <option value="Croatia" {{ old('country') == 'Croatia' ? 'selected' : '' }}>Croatia</option>
    <option value="Cuba" {{ old('country') == 'Cuba' ? 'selected' : '' }}>Cuba</option>
    <option value="Cyprus" {{ old('country') == 'Cyprus' ? 'selected' : '' }}>Cyprus</option>
    <option value="Czech Republic" {{ old('country') == 'Czech Republic' ? 'selected' : '' }}>Czech Republic</option>
    <option value="Denmark" {{ old('country') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
    <option value="Egypt" {{ old('country') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
    <option value="Estonia" {{ old('country') == 'Estonia' ? 'selected' : '' }}>Estonia</option>
    <option value="Ethiopia" {{ old('country') == 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
    <option value="Finland" {{ old('country') == 'Finland' ? 'selected' : '' }}>Finland</option>
    <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
    <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
    <option value="Greece" {{ old('country') == 'Greece' ? 'selected' : '' }}>Greece</option>
    <option value="Hong Kong" {{ old('country') == 'Hong Kong' ? 'selected' : '' }}>Hong Kong</option>
    <option value="Hungary" {{ old('country') == 'Hungary' ? 'selected' : '' }}>Hungary</option>
    <option value="Iceland" {{ old('country') == 'Iceland' ? 'selected' : '' }}>Iceland</option>
    <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
    <option value="Indonesia" {{ old('country') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
    <option value="Iran" {{ old('country') == 'Iran' ? 'selected' : '' }}>Iran</option>
    <option value="Iraq" {{ old('country') == 'Iraq' ? 'selected' : '' }}>Iraq</option>
    <option value="Ireland" {{ old('country') == 'Ireland' ? 'selected' : '' }}>Ireland</option>
    <option value="Italy" {{ old('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
    <option value="Japan" {{ old('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
    <option value="Jordan" {{ old('country') == 'Jordan' ? 'selected' : '' }}>Jordan</option>
    <option value="Kenya" {{ old('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
    <option value="Kuwait" {{ old('country') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
    <option value="Lebanon" {{ old('country') == 'Lebanon' ? 'selected' : '' }}>Lebanon</option>
    <option value="Libya" {{ old('country') == 'Libya' ? 'selected' : '' }}>Libya</option>
    <option value="Malaysia" {{ old('country') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
    <option value="Maldives" {{ old('country') == 'Maldives' ? 'selected' : '' }}>Maldives</option>
    <option value="Mauritius" {{ old('country') == 'Mauritius' ? 'selected' : '' }}>Mauritius</option>
    <option value="Mexico" {{ old('country') == 'Mexico' ? 'selected' : '' }}>Mexico</option>
    <option value="Morocco" {{ old('country') == 'Morocco' ? 'selected' : '' }}>Morocco</option>
    <option value="Nepal" {{ old('country') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
    <option value="Netherlands" {{ old('country') == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
    <option value="New Zealand" {{ old('country') == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
    <option value="Nigeria" {{ old('country') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
    <option value="Norway" {{ old('country') == 'Norway' ? 'selected' : '' }}>Norway</option>
    <option value="Oman" {{ old('country') == 'Oman' ? 'selected' : '' }}>Oman</option>
    <option value="Palestine" {{ old('country') == 'Palestine' ? 'selected' : '' }}>Palestine</option>
    <option value="Philippines" {{ old('country') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
    <option value="Poland" {{ old('country') == 'Poland' ? 'selected' : '' }}>Poland</option>
    <option value="Portugal" {{ old('country') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
    <option value="Qatar" {{ old('country') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
    <option value="Russia" {{ old('country') == 'Russia' ? 'selected' : '' }}>Russia</option>
    <option value="Singapore" {{ old('country') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
    <option value="South Africa" {{ old('country') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
    <option value="Spain" {{ old('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
    <option value="Sri Lanka" {{ old('country') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
    <option value="Sweden" {{ old('country') == 'Sweden' ? 'selected' : '' }}>Sweden</option>
    <option value="Switzerland" {{ old('country') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
    <option value="Syria" {{ old('country') == 'Syria' ? 'selected' : '' }}>Syria</option>
    <option value="Thailand" {{ old('country') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
    <option value="Turkey" {{ old('country') == 'Turkey' ? 'selected' : '' }}>Turkey</option>
    <option value="UAE" {{ old('country') == 'UAE' ? 'selected' : '' }}>United Arab Emirates</option>
    <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
    <option value="USA" {{ old('country') == 'USA' ? 'selected' : '' }}>United States</option>
    <option value="Uzbekistan" {{ old('country') == 'Uzbekistan' ? 'selected' : '' }}>Uzbekistan</option>
    <option value="Venezuela" {{ old('country') == 'Venezuela' ? 'selected' : '' }}>Venezuela</option>
    <option value="Vietnam" {{ old('country') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
    <option value="Yemen" {{ old('country') == 'Yemen' ? 'selected' : '' }}>Yemen</option>
    <option value="Zambia" {{ old('country') == 'Zambia' ? 'selected' : '' }}>Zambia</option>
    <option value="Zimbabwe" {{ old('country') == 'Zimbabwe' ? 'selected' : '' }}>Zimbabwe</option>
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
             
             // Set default country code for Pakistan if not selected
             const phoneCountryCode = document.getElementById('phone_country_code');
             const secondaryPhoneCountryCode = document.getElementById('secondary_phone_country_code');
             
             if (phoneCountryCode && !phoneCountryCode.value) {
                 phoneCountryCode.value = '+92'; // Default to Pakistan
             }
            
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
                         } else if (key === 'phone_number' || key === 'secondary_phone_number') {
                             // Handle phone numbers with country codes
                             const input = form.querySelector(`[name="${key}"]`);
                             if (input && data[key]) {
                                 // Remove country code from saved phone number if it exists
                                 const phoneWithoutCode = data[key].replace(/^\+?\d{1,4}/, '');
                                 input.value = phoneWithoutCode;
                             }
                         } else if (key === 'phone_country_code' || key === 'secondary_phone_country_code') {
                             // Load country codes
                             const select = form.querySelector(`[name="${key}"]`);
                             if (select) select.value = data[key];
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