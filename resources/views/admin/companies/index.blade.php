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
                                @if(auth()->user()->hasRole('super_admin'))
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

                        @if(auth()->user()->hasRole('Workspace Partners'))
                            <?php
                            $propertyType = request()->input('property_type');
                            ?>
                        <!-- ... existing code ... -->
                        <form action="{{ route('admin.companies.index') }}" method="GET" class="mb-3">
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <select name="property_type" id="property_type" class="form-control">
                                        <option value="">Select Property Type</option>
                                        <option value="owned" {{ $propertyType === 'owned' ? 'selected' : '' }}>Owned</option>
                                        <option value="not-owned" {{ $propertyType === 'not-owned' ? 'selected' : '' }}>Not Owned</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 mt-3">
                                    <button type="submit" class="btn btn-info">Apply</button>
                                </div>
                            </div>
                        </form>
                        @endif
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
                                        @if(auth()->user()->hasRole('super_admin'))
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
                                        @if(auth()->user()->hasRole('super_admin'))
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
                                                    $company->id)}}" method="post" onsubmit="return confirm('Are You Sure?')" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                                @endcan
                                                <a class="btn btn-primary btn-sm add-comment-btn" href="javascript:void()" data-company-id="{{ $company->id }}"  data-bs-toggle="modal" data-bs-target="#commentModal">Add Comment</a>
                                                <a class="btn btn-info btn-sm" href="{{ route('admin.companies.workspace-agreement', ['id' => $company->id]) }}">Work Agreement</a>
                                                <a class="btn btn-info btn-sm" href="{{ route('admin.companies.noc', ['id' => $company->id]) }}">NOC</a>
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

        <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        {{-- <h5 class="modal-title" id="exampleModalLabel">Comments</h5> --}}
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="commentForm">
                            <input type="hidden" name="company_id" id="modal-company-id">
                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                            {{-- <input type="text" name="user_id" id="modal-user-id"> --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea class="form-control" name="comment" required></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div class="mt-3">
                                        <button type="button" class="comment-btn btn btn-primary" id="submitCommentBtn">Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="comment-list" style="display: none;">
                            <h3>Comments</h3>
                            <div class="comment-list-wrapper" id="commentListWrapper">
                            </div>
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

        $('.add-comment-btn').on('click', function () {
            var companyId = $(this).data('company-id');
            // var userId = $(this).data('user-id');
            $('#modal-company-id').val(companyId);
            // $('#modal-user-id').val(userId);
        });

        $('#submitCommentBtn').click(function(e){
            e.preventDefault()
            let html ='';
            let url = "{{route('admin.comment')}}";
            var formData = $('#commentForm').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'post',
                url:url,
                data: formData,
                dataType: "json",
                success:function(res){
                    $("#commentListWrapper").html(res.data);
                    if (res.data.trim() !== '') {
                        $('.comment-list').css('display', 'block');
                    } else {
                        $('.comment-list').css('display', 'none');
                    }
                    successToast(res.msg);
                },
                error:function(res){
                    let errors = Object.values(res.responseJSON.errors);
                    errors.map((er)=>{
                        errorToast(er);
                    })
                },
            });
        });

        $('.add-comment-btn').click(function(e){
            var companyId = $(this).data('company-id');
            $.ajax({
                url: '{{ route("admin.fetch-comments", ":companyId") }}'.replace(':companyId', companyId),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var comments = response.comments;
                    var commentHtml = '';
                    $.each(comments, function(index, comment) {
                        var createdAt = new Date(comment.created_at);
                        var formattedDate = createdAt.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                        commentHtml += '<div class="comment-main-div">';
                        commentHtml += '<div class="comment-name-date">';
                        commentHtml += '<div class="user-name">' + comment.user_name + '</div>';
                        commentHtml += '<h6>' + formattedDate + '</h6>';
                        commentHtml += '</div>';
                        commentHtml += '<h5>' + comment.comment + '</h5>';
                        commentHtml += '</div>';
                    });
                    $('#commentListWrapper').html(commentHtml);
                    if (comments.length > 0) {
                        $('.comment-list').css('display','block');
                    } else {
                        $('.comment-list').css('display','none');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });

    });
</script>
@endsection
