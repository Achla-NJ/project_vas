@extends('admin.layout')
@section('css')
{{-- <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}"> --}}
<!-- Include Date Range Picker CSS from CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')

    <main class="content">
        <div class="mb-3 pt-5 pb-4">
            <h1 class="h3 d-inline align-middle">Manage Company</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card company-form">
                    <div class="card-body">
                        <form method="POST" action="{{(isset($company->id)) ? route('admin.companies.update',[$company->id]) : route('admin.companies.store') }}" enctype="multipart/form-data" novalidate>
                            @if(isset($company->id))@method('PUT')@endif
                            @csrf
                            <h5 class="mb-4">Company Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Registered Company Name:</label>
                                        <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $company->company_name ?? old('company_name')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="trade_name" class="form-label">Trade Name:</label>
                                        <input type="text" class="form-control" id="trade_name" name="trade_name" value="{{ $company->trade_name ?? old('trade_name')}}" >
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="firm_type" class="form-label">Type of Firm:</label>
                                        <select class="form-select" id="firm_type" name="firm_type">
                                            <option value="private_limited" {{  isset($company->firm_type) && $company->firm_type == 'private_limited'  ? 'selected' :'' }}>Private Limited Company</option>
                                            <option value="llp" {{  isset($company->firm_type) && $company->firm_type == 'llp'  ? 'selected' :'' }}>Limited Liability Partnership (LLP)</option>
                                            <option value="sole_proprietorship" {{  isset($company->firm_type) && $company->firm_type == 'sole_proprietorship'  ? 'selected' :'' }}>Sole Proprietorship</option>
                                            <option value="one_person_company" {{  isset($company->firm_type) && $company->firm_type == 'one_person_company'  ? 'selected' :'' }}>One Person Company</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="registered_address" class="form-label">Registered Address:</label>
                                        <textarea class="form-control" id="registered_address" name="registered_address" rows="1">{{ $company->registered_address ?? old('registered_address')}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gstin_no" class="form-label">GSTIN No:</label>
                                        <input type="text" class="form-control" id="gstin_no" name="gstin_no" value="{{ $company->gstin_no ?? old('gstin_no')}}" placeholder="29ABCDE1234F1Z5">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gst_file" class="form-label">GSTIN File:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="gst_file" name="gst_file" >
                                        @endif
                                            <a href="{{ !empty($company->gst_file) ? asset('storage/'.$company->gst_file) : 'javascript:void(0)'}}" target="_blank">
                                                @if(pathinfo(!empty($company->gst_file), PATHINFO_EXTENSION) === 'pdf')
                                                    <img src="{{asset('assets/images/icons/pdf-thumbnail.png')}}" alt="pdf" style="width:50px">
                                                @elseif(pathinfo(!empty($company->gst_file), PATHINFO_EXTENSION) === 'doc' || pathinfo(!empty($company->gst_file), PATHINFO_EXTENSION) === 'docx')
                                                <img src="{{asset('assets/images/icons/doc.png')}}" alt="pdf" style="width:50px">
                                                @else
                                                    <img id="imgPreview" src="{{ !empty($company->gst_file) ? asset('storage/'.$company->gst_file) : asset('assets/images/images_preview.png')}}" class="img-thumbnail" src="#" alt="pic" />
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="business_website" class="form-label">Business Website:</label>
                                        <input type="url" class="form-control" id="business_website" name="business_website" value="{{ $company->business_website ?? old('business_website')}}" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="industry" class="form-label">Industry:</label>
                                        <input type="text" class="form-control" id="industry" name="industry" value="{{ $company->industry ?? old('industry')}}" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="industry" class="form-label">Industry Field:</label>
                                        <input type="text" class="form-control" id="industry_field" name="industry_field" value="{{ $company->industry_field ?? old('industry_field')}}" >
                                    </div>
                                </div>
                                @if (session()->get('active_role')->slug == 'workspace-partners')
                                <div class="col-md-6">
                                    <div class="">
                                        <label class="form-label">Property Type:</label>
                                        <div class="d-flex property-type-wrapper">
                                            <div>
                                                <input type="radio" name="property_type" value="owned" {{isset($company->property_type) && !empty($company->property_type) && $company->property_type == 'owned' ? 'checked' : ''}} />
                                                <label for="">Owned</label>
                                            </div>
                                            <div>
                                                <input type="radio" name="property_type" value="not-owned" {{isset($company->property_type) && !empty($company->property_type) && $company->property_type == 'not-owned' ? 'checked' : ''}} />
                                                <label for="">Not Owned</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <h5 class="mb-4 mt-4">Company Owners / Directors Details</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="director_name" class="form-label">Name of the Director:</label>
                                        <input type="text" class="form-control" id="director_name" name="director_name" value="{{ $company->director_name ?? old('director_name')}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="aadhar_card_no" class="form-label">Aadhar Card No:</label>
                                        <input type="text" class="form-control" id="aadhar_card_no" name="aadhar_card_no" value="{{ $company->aadhar_card_no ?? old('aadhar_card_no')}}" placeholder="xxxx-xxxx-xxxx">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="aadhar_card_file" class="form-label">Aadhar Card File:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="aadhar_card_file" name="aadhar_card_file"  >
                                        @endif
                                        <a href="{{ !empty($company->aadhar_card_file) ? asset('storage/'.$company->aadhar_card_file) : 'javascript:void(0)'}}" target="_blank">
                                            @if(pathinfo(!empty($company->aadhar_card_file), PATHINFO_EXTENSION) === 'pdf')
                                                <img src="{{asset('assets/images/icons/pdf-thumbnail.png')}}" alt="pdf" style="width:50px">
                                            @elseif(pathinfo(!empty($company->aadhar_card_file), PATHINFO_EXTENSION) === 'doc' || pathinfo(!empty($company->aadhar_card_file), PATHINFO_EXTENSION) === 'docx')
                                            <img src="{{asset('assets/images/icons/doc.png')}}" alt="pdf" style="width:50px">
                                            @else
                                                <img id="imgPreview" src="{{ !empty($company->aadhar_card_file) ? asset('storage/'.$company->aadhar_card_file) : asset('assets/images/images_preview.png')}}" class="img-thumbnail" src="#" alt="pic" />
                                            @endif
                                        </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pan_card_no" class="form-label">Pan Card No:</label>
                                        <input type="text" class="form-control" id="pan_card_no" name="pan_card_no" value="{{ $company->pan_card_no ?? old('pan_card_no')}}" placeholder="ABCTY1234D">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="pan_card_file" class="form-label">Pan Card File:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="pan_card_file" name="pan_card_file">
                                        @endif
                                            <a href="{{ !empty($company->pan_card_file) ? asset('storage/'.$company->pan_card_file) : 'javascript:void(0)'}}" target="_blank">
                                                @if(pathinfo(!empty($company->pan_card_file), PATHINFO_EXTENSION) === 'pdf')
                                                    <img src="{{asset('assets/images/icons/pdf-thumbnail.png')}}" alt="pdf" style="width:50px">
                                                @elseif(pathinfo(!empty($company->pan_card_file), PATHINFO_EXTENSION) === 'doc' || pathinfo(!empty($company->pan_card_file), PATHINFO_EXTENSION) === 'docx')
                                                    <img src="{{asset('assets/images/icons/doc.png')}}" alt="pdf" style="width:50px">
                                                @else
                                                    <img id="imgPreview" src="{{ !empty($company->pan_card_file) ? asset('storage/'.$company->pan_card_file) : asset('assets/images/images_preview.png')}}" class="img-thumbnail" src="#" alt="pic" />
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @if(!isset($company->id))
                                <div class="col-md-6">
                                    <div class="mb-3 position-relative">
                                        <label for="mobile_no" class="form-label">Mobile No (OTP Verified):</label>
                                        <input type="tel" class="form-control" id="mobile_no" name="mobile_no" minlength="10" maxlength="10" required value="{{ $company->mobile_no ?? old('mobile_no')}}">
                                        <button class="btn btn-sm btn-primary get-otp-btn" type="button" onclick="generateAndSendOTP()">Get OTP</button>
                                    </div>
                                    <div class="mobile-otp-sent"></div>
                                </div>

                                <div class="col-md-6 mb-3">

                                    <div id="otp_verification" class="mb-3 position-relative">
                                        <label for="otp" class="form-label">Enter OTP:</label>
                                        <input type="text" class="form-control" id="otp" name="otp" >
                                        <button class="btn btn-sm btn-primary verify-otp-btn" type="button" onclick="verifyOTP()">Verify OTP</button>
                                    </div>
                                    <div class="otp-verified"></div>

                                    <input type="hidden" name="mobile_verified" id="mobile_verified" value="0">
                                </div>
                                @else
                                <div class="col-md-6">
                                    <div class="mb-3 position-relative">
                                        <label for="mobile_no" class="form-label">Mobile No:</label>
                                        <input type="tel" class="form-control" id="mobile_no" name="mobile_no" minlength="10" maxlength="10" required value="{{ $company->mobile_no ?? old('mobile_no')}}" readonly>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email_address" class="form-label">Email Address :</label>
                                        <input type="email" class="form-control" id="email_address" name="email_address" value="{{ $company->email_address ?? old('email_address')}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="local_address" class="form-label">Local Address:</label>
                                        <textarea class="form-control" id="local_address" name="local_address" rows="1">{{ $company->local_address ?? old('local_address')}}</textarea>
                                    </div>
                                </div>
                            </div>


                            <h5 class="mb-4 mt-4">Authorised Person Details</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="authorized_person_name" class="form-label">Name:</label>
                                        <input type="text" class="form-control" id="authorized_person_name" name="authorized_person_name" value="{{ $company->authorized_person_name ?? old('authorized_person_name')}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="contact_no" class="form-label">Contact No:</label>
                                        <input type="tel" class="form-control" id="contact_no" name="contact_no" value="{{ $company->contact_no ?? old('contact_no')}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="authorized_person_pan" class="form-label">Pan Card:</label>
                                        <input type="text" class="form-control" id="authorized_person_pan" name="authorized_person_pan" value="{{ $company->authorized_person_pan ?? old('authorized_person_pan')}}" placeholder="ABCTY1234D">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="authorized_person_pan_file" class="form-label">Pan Card File:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="authorized_person_pan_file" name="authorized_person_pan_file">
                                        @endif
                                            <a href="{{ !empty($company->authorized_person_pan_file) ? asset('storage/'.$company->authorized_person_pan_file) : 'javascript:void(0)'}}" target="_blank">
                                                @if(pathinfo(!empty($company->authorized_person_pan_file), PATHINFO_EXTENSION) === 'pdf')
                                                    <img src="{{asset('assets/images/icons/pdf-thumbnail.png')}}" alt="pdf" style="width:50px">
                                                @elseif(pathinfo(!empty($company->authorized_person_pan_file), PATHINFO_EXTENSION) === 'doc' || pathinfo(!empty($company->authorized_person_pan_file), PATHINFO_EXTENSION) === 'docx')
                                                <img src="{{asset('assets/images/icons/doc.png')}}" alt="pdf" style="width:50px">
                                                @else
                                                    <img id="imgPreview" src="{{ !empty($company->authorized_person_pan_file) ? asset('storage/'.$company->authorized_person_pan_file) : asset('assets/images/images_preview.png')}}" class="img-thumbnail" src="#" alt="pic" />
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="authorized_person_aadhar" class="form-label">Aadhar Card:</label>
                                        <input type="text" class="form-control" id="authorized_person_aadhar" name="authorized_person_aadhar" value="{{ $company->authorized_person_aadhar ?? old('authorized_person_aadhar')}}" placeholder="xxxx-xxxx-xxxx">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="authorized_person_aadhar_file" class="form-label">Aadhar Card File:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="authorized_person_aadhar_file" name="authorized_person_aadhar_file">
                                        @endif
                                            <a href="{{ !empty($company->authorized_person_aadhar_file) ? asset('storage/'.$company->authorized_person_aadhar_file) : 'javascript:void(0)'}}" target="_blank">
                                                @if(pathinfo(!empty($company->authorized_person_aadhar_file), PATHINFO_EXTENSION) === 'pdf')
                                                    <img src="{{asset('assets/images/icons/pdf-thumbnail.png')}}" alt="pdf" style="width:50px">
                                                @elseif(pathinfo(!empty($company->authorized_person_aadhar_file), PATHINFO_EXTENSION) === 'doc' || pathinfo(!empty($company->authorized_person_aadhar_file), PATHINFO_EXTENSION) === 'docx')
                                                <img src="{{asset('assets/images/icons/doc.png')}}" alt="pdf" style="width:50px">
                                                @else
                                                    <img id="imgPreview" src="{{ !empty($company->authorized_person_aadhar_file) ? asset('storage/'.$company->authorized_person_aadhar_file) : asset('assets/images/images_preview.png')}}" class="img-thumbnail" src="#" alt="pic" />
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-4 mt-4">Sources of Sales</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="work_agreement" class="form-label">Work Agreement:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="work_agreement" name="work_agreement">
                                        @endif
                                            @if (!empty($company->work_agreement))
                                            <a href="{{ asset('storage/'.$company->work_agreement)}}" target="_blank" class="badge badge-success badge-style-light me-3 py-2 form-control-sm">View Document</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="due_date" class="form-label">Due Date:</label>
                                        <input type="text" class="form-control" id="due_date" name="due_date" value="{{ isset($company->due_date)  ? $company->due_date->toDateString() : old('due_date')}}" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sales_type" class="form-label">Sales Type:</label>
                                        <input type="text" class="form-control" id="sales_type" readonly name="sales_type" value="{{  session()->get('active_role')->slug}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @if (session()->get('active_role')->slug == 'b2b')
                                    <div id="aggregator_name_container"  class="mb-3">
                                        <label for="aggregator_name" class="form-label">Aggregator Name:</label>
                                        <input type="text" class="form-control" id="aggregator_name" name="aggregator_name" value="{{ $company->aggregator_name ?? old('aggregator_name')}}" >
                                    </div>
                                    @endif

                                    @if (session()->get('active_role')->slug == 'b2c')
                                        <div id="employee_name_container"    class="mb-3">
                                            <label for="employee_name" class="form-label">Vselek’s Employee Name:</label>
                                            <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{ $company->employee_name ?? old('employee_name')}}" >
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if (session()->get('active_role')->slug == 'workspace-partners')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="electricity_bill" class="form-label">Electricity Bill:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="electricity_bill" name="electricity_bill">
                                        @endif
                                            @if (!empty($company->electricity_bill))
                                            <a href="{{ asset('storage/'.$company->electricity_bill)}}" target="_blank" class="badge badge-success badge-style-light me-3 py-2 form-control-sm">View Document</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="agreement" class="form-label">Agreement:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="agreement" name="agreement">
                                        @endif
                                            @if (!empty($company->agreement))
                                            <a href="{{ asset('storage/'.$company->agreement)}}" target="_blank" class="badge badge-success badge-style-light me-3 py-2 form-control-sm">View Document</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="private_bill" class="form-label">Private Bill:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="private_bill" name="private_bill">
                                        @endif
                                            @if (!empty($company->private_bill))
                                            <a href="{{ asset('storage/'.$company->private_bill)}}" target="_blank" class="badge badge-success badge-style-light me-3 py-2 form-control-sm">View Document</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="property_tax_receipt" class="form-label">Property Tax Receipt:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="property_tax_receipt" name="property_tax_receipt">
                                        @endif
                                            @if (!empty($company->property_tax_receipt))
                                            <a href="{{ asset('storage/'.$company->property_tax_receipt)}}" target="_blank" class="badge badge-success badge-style-light me-3 py-2 form-control-sm">View Document</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="municipal_khata" class="form-label">Municipal Khata:</label>
                                        <div class="company-file-fields">
                                        @if (isset($disp) && $disp =='1')
                                            <input type="file" class="form-control" id="municipal_khata" name="municipal_khata">
                                        @endif
                                            @if (!empty($company->municipal_khata))
                                            <a href="{{ asset('storage/'.$company->municipal_khata)}}" target="_blank" class="badge badge-success badge-style-light me-3 py-2 form-control-sm">View Document</a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('admin.companies.index') }}" class="btn back-btn"> Back</a>
                                </div>
                                <div class="col-6 text-end">
                                    {{-- @if (isset($disp) && $disp =='1')
                                        <button type="submit" class="btn btn-success save-btn mt-2" disabled>Save</button>
                                    @endif --}}
                                    @if(isset($company->id))
                                        <button type="submit" class="btn btn-success save-btn mt-2">Save</button>
                                        @else
                                        <button type="submit" class="btn btn-success save-btn mt-2" disabled>Save</button>
                                    @endif
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
@section('script')
    {{-- <script src="{{asset('assets/js/pages/select2.min.js')}}"></script> --}}
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

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
            var phoneNumber = $('#mobile_no').val();
            // Check if the mobile number matches the pattern
            if (!phoneNumber.match('[0-9]{10}')) {
                $('.mobile-otp-sent').html('Please enter a valid mobile number').show();
                setTimeout(function() {
                    $('.mobile-otp-sent').hide();
                }, 10000);
                return;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "post",
                url:"{{route('admin.send-company-otp')}}",
                data: {
                    phone_number: phoneNumber
                },
                success: function(response) {
                    // Handle success response
                    $('.mobile-otp-sent').addClass('success');
                    $('.mobile-otp-sent').removeClass('danger');
                    $('.mobile-otp-sent').html(response.message).show();
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    $('.mobile-otp-sent').addClass('success');
                    $('.mobile-otp-sent').removeClass('danger');
                    $('.mobile-otp-sent').html('Failed to send OTP. Please try again later.').show();
                }
            });
        }
        function verifyOTP() {

            event.preventDefault();

            var phoneNumber = $('#mobile_no').val();
            var otp = $('#otp').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.verify-company-otp')}}",
                method: 'POST',
                data: {
                    phone_number: phoneNumber,
                    otp: otp
                },
                success: function(response) {
                    // Handle success response
                    // alert(response.message);
                    $('.otp-verified').addClass('success');
                    $('.otp-verified').removeClass('danger');
                    $('.otp-verified').html(response.message);
                    $('.save-btn').prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    $('.otp-verified').addClass('danger');
                    $('.otp-verified').removeClass('success');
                    $('.otp-verified').html('Failed to verify OTP. Please try again later.');
                    // alert('Failed to verify OTP. Please try again later.');
                }
            });
        }

        @if (isset($disp) && $disp =='1')
            $("form input").prop("disabled", false);
            $("form textarea").prop("disabled", false);
            $("form select").prop("disabled", false);
            $("form radio").prop("disabled", false);
            $("form checkbox").prop("disabled", false);

        @else
            $("form input").prop("disabled", true);
            $("form textarea").prop("disabled", true);
            $("form select").prop("disabled", true);
            $("form radio").prop("disabled", true);
            $("form radio").prop("disabled", true);
            $("form checkbox").prop("disabled", true);

        @endif

        @if(isset($company))
            var dueDate = '{{ $company->due_date->format('d-m-Y') }}';
            $('input[name="due_date"]').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD-MM-YYYY'
                },
                startDate: dueDate
            });
        @else
            $('input[name="due_date"]').daterangepicker({
                singleDatePicker: true,
                locale: {
                    format: 'DD-MM-YYYY'
                }
            });
        @endif
</script>

    </script>


@endsection
