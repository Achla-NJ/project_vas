@extends('admin.layout')
@section('css')
    
@endsection
@section('content')
<div class="bg-light">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Task Status</h1>
            <a href="{{ route('admin.task-statuses.create') }}"
                class="btn btn-primary btn-sm text-right">Add Task Status</a>
        </div>
        <div class="row">
            <div class="col-12">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            {{Session::get('success')}}
                        </div>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <table id="datatables-reponsive"
                            class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Name</th>
                                    <th>Color</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($task_statuses as $task_status)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $task_status->name }}</td>
                                        <td><div style="background:{{ $task_status->color }}; height:20px; width:20px;"></div></td>
                                        <td>
                                            <form action="{{route('admin.task-statuses.destroy',
                                            $task_status->id)}}" method="post" onsubmit="return confirm('Are You Sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-info btn-sm" href="{{ route('admin.task-statuses.edit', $task_status->id) }}">Edit</a>
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>    
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
@section('script')
<script src="{{asset('assets/js/datatables.js')}}"></script>
<script>
    $("#datatables-reponsive").DataTable({
        responsive: true
    });
</script>
@endsection