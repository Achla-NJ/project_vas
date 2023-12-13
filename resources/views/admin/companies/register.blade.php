@extends('admin.layout')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endsection
@section('content')
<div class="bg-light  rounded">
    <main class="content">
        <div class="mb-3 pt-5 pb-4">
            <h1 class="h3 d-inline align-middle">Register Company</h1>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{(isset($company->id)) ? route('admin.companies.update',[$company->id]) : route('admin.companies.store') }}">
                            @if(isset($company->id))@method('PUT')@endif
                            @csrf 
                            
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Registered Company Name:</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $company->company_name ?? old('company_name')}}" required>
                            </div>

                            <div class="mb-3">
                                <label for="mobile_no" class="form-label">Mobile No (OTP Verified):</label>
                                <input type="tel" class="form-control" id="mobile_no" name="mobile_no" required value="{{ $company->mobile_no ?? old('mobile_no')}}" >
                                <button class="btn btn-sm btn-primary" type="button" onclick="generateAndSendOTP()">Get OTP</button>
                            </div>
                            
                            <!-- OTP Verification Section (Initially Hidden) -->
                            <div id="otp_verification" style="display: none;" class="mb-3">
                                <label for="otp" class="form-label">Enter OTP:</label>
                                <input type="text" class="form-control" id="otp" name="otp" required>
                            </div>
                            
                            <input type="hidden" name="mobile_verified" id="mobile_verified" value="0">
                            
                            

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
</div>
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