@extends('admin.layout')
@section('css')
{{-- <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}"> --}}
<!-- Include Date Range Picker CSS from CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')

    <main class="content">
        <div class="mb-3 pt-5 pb-4">
            <h1 class="h3 d-inline align-middle">NOC</h1>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card company-form">
                    <div class="card-body">
                        <form method="POST" action="{{route('admin.companies.noc.update') }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            <input type="hidden" name="company_id" value={{$company->id}}>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="noc_date" class="form-label">VSELEK COWORKING & COWAREHOUSING PRIVATE LIMITED ON:</label>
                                        <input type="text" class="form-control" id="noc_date" name="noc_date" value="{{ isset($noc->noc_date)  ? $noc->noc_date->toDateString() : old('noc_date')}}" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="noc_time" class="form-label">AT (Time):</label>
                                        <input type="time" class="form-control" id="noc_time" name="noc_time" value="{{ isset($noc->noc_time)  ? $noc->noc_time : old('noc_time')}}" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="company_name" class="form-label">Proposed Company:</label>
                                        <textarea name="company_name"  class="form-control" cols="50" readonly>{{$company->company_name}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="company_address" class="form-label">Company Address:</label>
                                        <textarea name="company_address"  class="form-control" cols="50" readonly>{{$company->registered_address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="pan_number" class="form-label">Pan Number:</label>
                                        <input type="text" id="pan_number" class="form-control" name="pan_number" value="{{$company->pan_card_no}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="mobile_number" class="form-label">Mobile Number:</label>
                                        <input type="text" id="mobile_number" class="form-control" name="mobile_number" value="{{$company->mobile_no}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 text-end">
                                    <button type="submit" class="btn btn-success save-btn mt-2">Save</button>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>

    @if(isset($noc))
        var nocDate = '{{ $noc->noc_date->format('d-m-Y') }}';

        $('input[name="noc_date"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            startDate: nocDate
        });
    @else
        $('input[name="noc_date"]').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
    @endif


</script>
@endsection
