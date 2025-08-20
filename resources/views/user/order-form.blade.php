@extends('layouts.app')

@section('title', 'Order Semester Notes')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header">
                    <h1><i class="fas fa-book me-3"></i>Order Semester Notes</h1>
                    <p class="mb-0 mt-2 opacity-90">Fill out the form below to order your semester notes</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            @if(session('show_track_button') && session('order_id'))
                                <div class="mt-3">
                                    <strong>Your Order ID: #{{ session('order_id') }}</strong>
                                    <br>
                                    <a href="{{ route('tracking.index') }}" class="btn btn-info btn-sm mt-2">
                                        <i class="fas fa-search me-2"></i>Track Your Order
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

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

                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-2"></i>Full Name *
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Phone Number *
                                </label>
                                <input type="tel" 
                                       class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" 
                                       name="phone_number" 
                                       value="{{ old('phone_number') }}" 
                                       required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="secondary_phone_number" class="form-label">
                                    <i class="fas fa-phone-alt me-2"></i>Secondary Phone Number
                                </label>
                                <input type="tel" 
                                       class="form-control @error('secondary_phone_number') is-invalid @enderror" 
                                       id="secondary_phone_number" 
                                       name="secondary_phone_number" 
                                       value="{{ old('secondary_phone_number') }}">
                                @error('secondary_phone_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="full_address" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Full Address *
                            </label>
                            <textarea class="form-control @error('full_address') is-invalid @enderror" 
                                      id="full_address" 
                                      name="full_address" 
                                      rows="3" 
                                      required>{{ old('full_address') }}</textarea>
                            @error('full_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">
                                    <i class="fas fa-city me-2"></i>City *
                                </label>
                                <input type="text" 
                                       class="form-control @error('city') is-invalid @enderror" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city') }}" 
                                       required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label for="country" class="form-label">
                                    <i class="fas fa-globe me-2"></i>Country *
                                </label>
                                <select class="form-control @error('country') is-invalid @enderror" 
                                        id="country" 
                                        name="country" 
                                        required>
                                    <option value="">Select your country</option>
                                    <optgroup label="Most Popular">
                                        <option value="Pakistan" {{ old('country', 'Pakistan') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                        <option value="Saudi Arabia" {{ old('country') == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                    </optgroup>
                                    <optgroup label="South Asian Countries">
                                        <option value="Afghanistan" {{ old('country') == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                        <option value="Bangladesh" {{ old('country') == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                        <option value="Bhutan" {{ old('country') == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
                                        <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                        <option value="Maldives" {{ old('country') == 'Maldives' ? 'selected' : '' }}>Maldives</option>
                                        <option value="Nepal" {{ old('country') == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                                        <option value="Sri Lanka" {{ old('country') == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                    </optgroup>
                                    <optgroup label="Middle Eastern Countries">
                                        <option value="Bahrain" {{ old('country') == 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
                                        <option value="Iran" {{ old('country') == 'Iran' ? 'selected' : '' }}>Iran</option>
                                        <option value="Iraq" {{ old('country') == 'Iraq' ? 'selected' : '' }}>Iraq</option>
                                        <option value="Jordan" {{ old('country') == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                                        <option value="Kuwait" {{ old('country') == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                        <option value="Lebanon" {{ old('country') == 'Lebanon' ? 'selected' : '' }}>Lebanon</option>
                                        <option value="Oman" {{ old('country') == 'Oman' ? 'selected' : '' }}>Oman</option>
                                        <option value="Qatar" {{ old('country') == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                        <option value="Syria" {{ old('country') == 'Syria' ? 'selected' : '' }}>Syria</option>
                                        <option value="Turkey" {{ old('country') == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                                        <option value="United Arab Emirates" {{ old('country') == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                        <option value="Yemen" {{ old('country') == 'Yemen' ? 'selected' : '' }}>Yemen</option>
                                    </optgroup>
                                    <optgroup label="Southeast Asian Countries">
                                        <option value="Brunei" {{ old('country') == 'Brunei' ? 'selected' : '' }}>Brunei</option>
                                        <option value="Cambodia" {{ old('country') == 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
                                        <option value="Indonesia" {{ old('country') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                        <option value="Laos" {{ old('country') == 'Laos' ? 'selected' : '' }}>Laos</option>
                                        <option value="Malaysia" {{ old('country') == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                        <option value="Myanmar" {{ old('country') == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
                                        <option value="Philippines" {{ old('country') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                        <option value="Singapore" {{ old('country') == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                        <option value="Thailand" {{ old('country') == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                        <option value="Vietnam" {{ old('country') == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                    </optgroup>
                                    <optgroup label="Western Countries">
                                        <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                        <option value="Austria" {{ old('country') == 'Austria' ? 'selected' : '' }}>Austria</option>
                                        <option value="Belgium" {{ old('country') == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                                        <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                        <option value="Denmark" {{ old('country') == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                                        <option value="Finland" {{ old('country') == 'Finland' ? 'selected' : '' }}>Finland</option>
                                        <option value="France" {{ old('country') == 'France' ? 'selected' : '' }}>France</option>
                                        <option value="Germany" {{ old('country') == 'Germany' ? 'selected' : '' }}>Germany</option>
                                        <option value="Ireland" {{ old('country') == 'Ireland' ? 'selected' : '' }}>Ireland</option>
                                        <option value="Italy" {{ old('country') == 'Italy' ? 'selected' : '' }}>Italy</option>
                                        <option value="Netherlands" {{ old('country') == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                        <option value="New Zealand" {{ old('country') == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                        <option value="Norway" {{ old('country') == 'Norway' ? 'selected' : '' }}>Norway</option>
                                        <option value="Portugal" {{ old('country') == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                        <option value="Spain" {{ old('country') == 'Spain' ? 'selected' : '' }}>Spain</option>
                                        <option value="Sweden" {{ old('country') == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                                        <option value="Switzerland" {{ old('country') == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                                        <option value="United Kingdom" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                        <option value="United States" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                                    </optgroup>
                                    <optgroup label="African Countries">
                                        <option value="Algeria" {{ old('country') == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                                        <option value="Egypt" {{ old('country') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                        <option value="Ethiopia" {{ old('country') == 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
                                        <option value="Ghana" {{ old('country') == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                        <option value="Kenya" {{ old('country') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                        <option value="Morocco" {{ old('country') == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                                        <option value="Nigeria" {{ old('country') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                        <option value="South Africa" {{ old('country') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                        <option value="Tanzania" {{ old('country') == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                        <option value="Uganda" {{ old('country') == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                    </optgroup>
                                    <optgroup label="East Asian Countries">
                                        <option value="China" {{ old('country') == 'China' ? 'selected' : '' }}>China</option>
                                        <option value="Japan" {{ old('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
                                        <option value="North Korea" {{ old('country') == 'North Korea' ? 'selected' : '' }}>North Korea</option>
                                        <option value="South Korea" {{ old('country') == 'South Korea' ? 'selected' : '' }}>South Korea</option>
                                        <option value="Mongolia" {{ old('country') == 'Mongolia' ? 'selected' : '' }}>Mongolia</option>
                                        <option value="Taiwan" {{ old('country') == 'Taiwan' ? 'selected' : '' }}>Taiwan</option>
                                    </optgroup>
                                    <optgroup label="Latin American Countries">
                                        <option value="Argentina" {{ old('country') == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                        <option value="Brazil" {{ old('country') == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                        <option value="Chile" {{ old('country') == 'Chile' ? 'selected' : '' }}>Chile</option>
                                        <option value="Colombia" {{ old('country') == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                                        <option value="Mexico" {{ old('country') == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                                        <option value="Peru" {{ old('country') == 'Peru' ? 'selected' : '' }}>Peru</option>
                                        <option value="Venezuela" {{ old('country') == 'Venezuela' ? 'selected' : '' }}>Venezuela</option>
                                    </optgroup>
                                    <optgroup label="Other">
                                        <option value="Other" {{ old('country') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </optgroup>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-graduation-cap me-2"></i>Select Semesters * 
                                <small class="text-muted">(You can select multiple semesters)</small>
                            </label>
                            <div class="alert alert-info mb-3" role="alert">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>یہاں وہ سمسٹر منتخب کریں جس کے آپ کو نوٹس چاہیے، آپ ایک سے زیادہ سمسٹرز بھی منتخب کر سکتے ہیں</strong>
                            </div>
                            <div class="row">
                                @php
                                    $semesters = ['Semester 1', 'Semester 2', 'Semester 3', 'Semester 4', 'Semester 5', 'Semester 6', 'Semester 7'];
                                    $oldSemesters = old('semesters', []);
                                @endphp
                                @foreach($semesters as $semester)
                                    <div class="col-md-6 col-lg-4">
                                        <input type="checkbox" 
                                               class="semester-checkbox" 
                                               id="semester_{{ $loop->iteration }}" 
                                               name="semesters[]" 
                                               value="{{ $semester }}"
                                               {{ in_array($semester, $oldSemesters) ? 'checked' : '' }}>
                                        <label for="semester_{{ $loop->iteration }}" class="semester-label">
                                            <i class="fas fa-book-open me-2"></i>{{ $semester }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('semesters')
                                <div class="text-danger mt-2">
                                    <small><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Fees Payment Status *
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="radio" 
                                               class="form-check-input form-check-input-lg @error('fees_paid') is-invalid @enderror" 
                                               id="fees_paid_yes" 
                                               name="fees_paid" 
                                               value="1"
                                               {{ old('fees_paid') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="fees_paid_yes">
                                            <strong class="text-success">Paid</strong>
                                            <small class="text-muted d-block">I have already paid the fees</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input type="radio" 
                                               class="form-check-input form-check-input-lg @error('fees_paid') is-invalid @enderror" 
                                               id="fees_paid_no" 
                                               name="fees_paid" 
                                               value="0"
                                               {{ old('fees_paid') == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="fees_paid_no">
                                            <strong class="text-danger">Not Paid</strong>
                                            <small class="text-muted d-block">I will pay later</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('fees_paid')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="remarks" class="form-label">
                                <i class="fas fa-comment me-2"></i>Remarks / Special Instructions
                            </label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" 
                                      id="remarks" 
                                      name="remarks" 
                                      rows="4" 
                                      placeholder="Any special instructions or notes for your order...">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>Submit Order
                            </button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                We will contact you within 24 hours to confirm your order
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .form-check-input-lg {
        width: 1.5rem !important;
        height: 1.5rem !important;
        margin-top: 0.125rem;
    }
    
    .form-check-input-lg:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    
    .form-check-label {
        margin-left: 0.5rem;
        cursor: pointer;
    }
</style>
@endsection

@section('scripts')
<script>
    // Add some interactive feedback for semester selection
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.semester-checkbox');
        const submitBtn = document.querySelector('button[type="submit"]');
        
        function updateSubmitButton() {
            const checkedBoxes = document.querySelectorAll('.semester-checkbox:checked');
            if (checkedBoxes.length > 0) {
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Order (' + checkedBoxes.length + ' semester' + (checkedBoxes.length > 1 ? 's' : '') + ')';
            } else {
                submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Order';
            }
        }
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSubmitButton);
        });
        
        // Initial update
        updateSubmitButton();
    });
</script>
@endsection
