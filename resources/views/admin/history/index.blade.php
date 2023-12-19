@extends('admin.layout')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css">
@endsection
@section('content')

<div class="row">
    <div class="col">
        <div class="page-description">
            <h1>Version History</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="history-wrapper card widget widget-list">
            <div class="card-header">
                <form action="{{ route('admin.history.index') }}" method="GET" class="mb-3">
                    <div class="row" style="align-items: end;">
                        @if(auth()->user()->hasRole('super_admin'))
                        <div class="col-md-4">
                            <label for="user_id" class="form-label">Select User:</label>
                            <select name="user_id" id="user_id" class="form-control">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-4">
                            <label for="date_range" class="form-label">Date:</label>
                            <input type="text" name="date_range" id="date_range" class="form-control" value="{{ request('date_range') }}" autocomplete="off">
                        </div>

                        <div class="col-md-4 mt-3 filter-btn">
                            <button type="submit" class="btn btn-info">Apply</button>
                            <a href="{{ route('admin.history.index')}}" class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                {{-- @dd($activities) --}}
                @if (count($activities) > 0)
                    <x-history :activities="$activities"/>
                @else
                    <p>No updates yet</p>
                @endif
                {{ $activities->links() }}

            </div>
        </div>
    </div>
</div>

@endsection


@section('script')

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

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
