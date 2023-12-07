@extends('admin.layout')
@section('css')
    
@endsection
@section('content')
<div class="bg-light">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Tasks</h1>
            <a href="{{ route('admin.tasks.create') }}"  class="btn btn-primary btn-sm text-right">Add Task</a>
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
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>Deadline</th>
                                    <th>Estimate Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $key => $task)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><div onclick="openPopup('{{ route('admin.tasks.show', $task->id) }}')">{{ $task->name }}</div></td>
                                    <td>{{date('M d, Y',strtotime($task->start_date))}}</td>
                                    <td>{{date('M d, Y',strtotime($task->end_date))}}</td>
                                    <td>{{$task->estimate_time}} {{$task->estimate_type}}</td>
                                    <td><span class="badge" style="background: {{$task->task_status->color}}">{{ucfirst($task->task_status->name)}}</span></td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-success btn-sm" onclick="openPopup('{{ route('admin.tasks.show', $task->id) }}')" href="javascript:void(0)">Show</a>
                                            @can('edit_task')
                                            <a class="btn btn-info btn-sm" href="{{ route('admin.tasks.edit', $task->id) }}">Edit</a>
                                            @endcan
                                            @can('delete_task')
                                                <form action="{{route('admin.tasks.destroy',
                                                $task->id)}}" method="post" onsubmit="return confirm('Are You Sure?')">
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
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#defaultModalPrimary">
            Primary
        </button>
        <div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Default modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3" id="content">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</div>
@endsection

@section('script')
<script>
    function openPopup(url){        
        $.ajax({
            type: "get",
            url,
            data:{},
            success:function(response){
                $("#content").html(response);
                $('.modal').modal('show');
            }
        })
    }
</script>
<script src="{{asset('assets/js/datatables.js')}}"></script>
<script>
    $("#datatables-reponsive").DataTable({
        responsive: true
    });
</script>
@endsection