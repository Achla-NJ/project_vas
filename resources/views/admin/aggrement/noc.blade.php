@extends('admin.layout')
@section('css')

<!-- Include Date Range Picker CSS from CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css">
@endsection
@section('content')

    <main class="content">
        <div class="d-flex justify-content-between align-items-center mb-0 mb-md-3 pt-5 pb-3">
            <h1 class="fw-bold d-inline align-middle">NOC Agreement</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datatables-reponsive"
                                class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Company Name</th>
                                        <th>Agreement Date</th>
                                        <th>Last Updated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nocs as $noc)
                                    <tr>
                                        <td>{{ $noc->id }}</td>
                                        <td>{{ $noc->company->company_name }}</td>
                                        <td>{{ date('d M , Y',strtotime($noc->noc_date)) }}</td>
                                        <td>{{ date('d M , Y',strtotime($noc->created_at)) }}</td>
                                        <td><a class="btn btn-info btn-sm" href="{{ asset('storage/pdfs/'. $noc->pdf) }}" target="_blank" download>Download PDF</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

{{-- @section('script')
<script src="{{asset('assets/js/datatables.js')}}"></script>
<script>
    $("#datatables-reponsive").DataTable({
        responsive: true
    });
</script>
@endsection --}}
