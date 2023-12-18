@extends('admin.layout')
@section('css')

<!-- Include Date Range Picker CSS from CDN -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css">
@endsection
@section('content')

    <main class="content">
        <div class="d-flex justify-content-between align-items-center mb-0 mb-md-3 pt-5 pb-3">
            <h1 class="fw-bold d-inline align-middle">Companies</h1>
            <a href="{{ route('admin.companies.create') }}"
                class="btn btn-success btn-sm text-right">Add Company</a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Add Filters Form -->
                        <form action="{{ route('admin.companies.index') }}" method="GET" class="mb-3">
                            <div class="row" style="align-items: end;">
                                @if(auth()->user()->hasRole('admin'))
                                <div class="col-lg-4">
                                    <label for="user_id" class="form-label">Select User:</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">All Users</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-lg-4">
                                    <label for="search" class="form-label">Search Company:</label>
                                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" >
                                </div>
                                <div class="col-lg-4">
                                    <label for="date_range" class="form-label">Date:</label>
                                    <input type="text" name="date_range" id="date_range" class="form-control" value="{{ request('date_range') }}" autocomplete="off">
                                </div>


                                <div class="col-lg-4 mt-3">
                                    <button type="submit" class="btn btn-info">Apply</button>
                                    <a href="{{ route('admin.companies.index')}}" class="btn btn-danger">Reset</a>
                                </div>
                            </div>
                        </form>

                        <!-- ... existing code ... -->
                    </div>
                </div>
            </div>
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
                                        @if(auth()->user()->hasRole('admin'))
                                        <th>Added By</th>
                                        @endif
                                        <th>Firm Type</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $key => $company)
                                    <tr>
                                        <td>{{ $company->id }}</td>
                                        <td>{{ $company->company_name }}</td>
                                        @if(auth()->user()->hasRole('admin'))
                                            <td><a href='{{ route('admin.users.show', $company->user_id) }}'><span class="badge badge-success badge-style-light form-control-sm">{{ $company->user->name }}</span></a></td>
                                        @endif
                                        {{-- <td><span class="badge badge-success badge-style-light form-control-sm">{{ $company->role->name }}</span></td> --}}

                                        <td>{{ ucwords(str_replace('_',' ',$company->firm_type)) }}</td>
                                        <td>{{ date('d M , Y',strtotime($company->due_date)) }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-success btn-sm" href="{{ route('admin.companies.show', $company->id) }}">Show</a>
                                                @can('company_update')
                                                <a class="btn btn-info btn-sm" href="{{ route('admin.companies.edit', $company->id) }}">Edit</a>
                                                @endcan
                                                @can('company_delete')
                                                    <form action="{{route('admin.companies.destroy',
                                                    $company->id)}}" method="post" onsubmit="return confirm('Are You Sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                @endcan
                                            </div>

                                        </td>
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

@section('script')
<script src="{{asset('assets/js/datatables.js')}}"></script>
<!-- Include Date Range Picker JS from CDN -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js"></script>

<script>
    $("#datatables-reponsive").DataTable({
        responsive: true
    });
</script>
<script>
    // Initialize Date Range Picker
    $(document).ready(function() {
        $('#date_range').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        // Update the input field when the date range is selected
        $('#date_range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
        });

        // Clear the input field when the "Clear" button is clicked
        $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
    });
</script>
@endsection
