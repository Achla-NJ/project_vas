@extends('admin.layout')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endsection
@section('content')

    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Manage Company</h1>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{(isset($company->id)) ? route('admin.companies.update',[$company->id]) : route('admin.companies.store') }}">
                            @if(isset($company->id))@method('PUT')@endif
                            @csrf
                            <h2 class="mb-4">Company Information</h2>
                            
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Registered Company Name:</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $company->company_name ?? old('company_name')}}" required>
                            </div>

                            <div class="mb-3">
                                <label for="trade_name" class="form-label">Trade Name:</label>
                                <input type="text" class="form-control" id="trade_name" name="trade_name" required value="{{ $company->trade_name ?? old('trade_name')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="firm_type" class="form-label">Type of Firm:</label>
                                <select class="form-select" id="firm_type" name="firm_type" required>
                                    <option value="private_limited" {{  isset($company->firm_type) && $company->firm_type == 'private_limited'  ? 'selected' :'' }}>Private Limited Company</option>
                                    <option value="llp" {{  isset($company->firm_type) && $company->firm_type == 'llp'  ? 'selected' :'' }}>Limited Liability Partnership (LLP)</option>
                                    <option value="sole_proprietorship" {{  isset($company->firm_type) && $company->firm_type == 'sole_proprietorship'  ? 'selected' :'' }}>Sole Proprietorship</option>
                                    <option value="one_person_company" {{  isset($company->firm_type) && $company->firm_type == 'one_person_company'  ? 'selected' :'' }}>One Person Company</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="registered_address" class="form-label">Registered Address:</label>
                                <textarea class="form-control" id="registered_address" name="registered_address" rows="4" required>{{ $company->registered_address ?? old('registered_address')}}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="gstin_no" class="form-label">GSTIN No:</label>
                                <input type="text" class="form-control" id="gstin_no" name="gstin_no" required value="{{ $company->gstin_no ?? old('gstin_no')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="business_website" class="form-label">Business Website:</label>
                                <input type="url" class="form-control" id="business_website" name="business_website" value="{{ $company->business_website ?? old('business_website')}}" >
                            </div>

                            <h2 class="mb-4">Company Owners / Directors Details</h2>

                            <div class="mb-3">
                                <label for="director_name" class="form-label">Name of the Director:</label>
                                <input type="text" class="form-control" id="director_name" name="director_name" required value="{{ $company->director_name ?? old('director_name')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="aadhar_card_no" class="form-label">Aadhar Card No:</label>
                                <input type="text" class="form-control" id="aadhar_card_no" name="aadhar_card_no" required value="{{ $company->aadhar_card_no ?? old('aadhar_card_no')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="pan_card_no" class="form-label">Pan Card No:</label>
                                <input type="text" class="form-control" id="pan_card_no" name="pan_card_no" required value="{{ $company->pan_card_no ?? old('pan_card_no')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="mobile_no" class="form-label">Mobile No (OTP Verified):</label>
                                <input type="tel" class="form-control" id="mobile_no" name="mobile_no" required value="{{ $company->mobile_no ?? old('mobile_no')}}" >
                                {{-- <button class="btn btn-sm btn-primary" type="button" onclick="generateAndSendOTP()">Get OTP</button> --}}
                            </div>
                            
                            <!-- OTP Verification Section (Initially Hidden) -->
                            <div id="otp_verification" style="display: none;" class="mb-3">
                                <label for="otp" class="form-label">Enter OTP:</label>
                                <input type="text" class="form-control" id="otp" name="otp" >
                            </div>
                            
                            <input type="hidden" name="mobile_verified" id="mobile_verified" value="0">
                            

                            <div class="mb-3">
                                <label for="email_address" class="form-label">Email Address :</label>
                                <input type="email" class="form-control" id="email_address" name="email_address" required value="{{ $company->email_address ?? old('email_address')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="local_address" class="form-label">Local Address:</label>
                                <textarea class="form-control" id="local_address" name="local_address" rows="4" required >{{ $company->local_address ?? old('local_address')}}</textarea>
                            </div>

                            <h2 class="mb-4">Authorised Person Details</h2>

                            <div class="mb-3">
                                <label for="authorized_person_name" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="authorized_person_name" name="authorized_person_name" required value="{{ $company->authorized_person_name ?? old('authorized_person_name')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="contact_no" class="form-label">Contact No:</label>
                                <input type="tel" class="form-control" id="contact_no" name="contact_no" required value="{{ $company->contact_no ?? old('contact_no')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="authorized_person_aadhar" class="form-label">Aadhar Card:</label>
                                <input type="text" class="form-control" id="authorized_person_aadhar" name="authorized_person_aadhar" required value="{{ $company->authorized_person_aadhar ?? old('authorized_person_aadhar')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="authorized_person_pan" class="form-label">Pan Card:</label>
                                <input type="text" class="form-control" id="authorized_person_pan" name="authorized_person_pan" required value="{{ $company->authorized_person_pan ?? old('authorized_person_pan')}}" >
                            </div>

                            <h2 class="mb-4">Sources of Sales</h2>

                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date:</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" required value="{{ $company->due_date ?? old('due_date')}}" >
                            </div>

                            <div class="mb-3">
                                <label for="sales_type" class="form-label">Sales Type:</label>
                                <select class="form-select" id="sales_type" name="sales_type" required>
                                    <option value="b2b" {{  isset($company->aggregator_name) && $company->aggregator_name == 'b2b'  ? 'selected' :'' }}>B2B</option>
                                    <option value="b2c"{{  isset($company->aggregator_name) && $company->aggregator_name == 'b2c'  ? 'selected' :'' }}>B2C</option>
                                </select>
                            </div>

                            <div id="aggregator_name_container" style="display: none;" class="mb-3">
                                <label for="aggregator_name" class="form-label">Aggregator Name:</label>
                                <input type="text" class="form-control" id="aggregator_name" name="aggregator_name" value="{{ $company->aggregator_name ?? old('aggregator_name')}}" >
                            </div>

                            <div id="employee_name_container" style="display: none;" class="mb-3">
                                <label for="employee_name" class="form-label">Vselek’s Employee Name:</label>
                                <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{ $company->employee_name ?? old('employee_name')}}" >
                            </div>

                            @if (isset($disp) && $disp =='1')
                                <button type="submit" class="btn btn-primary">Save</button>
                            @endif
                            <a href="{{ route('admin.companies.index') }}" class="btn btn-default">Back</a>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>

    </main>
    
@endsection
@section('script')
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    

    <script>
        document.getElementById('sales_type').addEventListener('change', function() {
            var aggregator_container = document.getElementById('aggregator_name_container');
            var employee_container = document.getElementById('employee_name_container');

            aggregator_container.style.display = 'none';
            employee_container.style.display = 'none';

            if (this.value === 'b2b') {
                aggregator_container.style.display = 'block';
            } else if (this.value === 'b2c') {
                employee_container.style.display = 'block';
            }
        });

        function generateAndSendOTP() {
            
            document.getElementById('otp_verification').style.display = 'block';
        }
    </script>
@endsection