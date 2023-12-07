@extends('admin.layout')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endsection
@section('content')
<div class="bg-light  rounded">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Manage Task</h1>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <div class="alert-message">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        
                        <form method="POST" action="{{(isset($task->id)) ? route('admin.tasks.update',[$task->id]) : route('admin.tasks.store') }}">
                            @if(isset($task->id))@method('PUT')@endif
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Title</label>
                                    <input value="{{ $task->name  ?? old('name') }}" 
                                        type="text" 
                                        class="form-control" 
                                        name="name" 
                                        placeholder="Title" >
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Project</label>
                                    <select name="project_id" class="form-select" id="project_id" onchange="getUsers()">
                                        <option value="">-Select-</option>
                                        @foreach ($projects as $project)
                                            <option value="{{$project->id}}" {{ (isset($task->project_id) && ($task->project_id == $project->id)) ? 'selected':''}}>{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Assign To</label>
                                    <select name="assign_id" class="form-select" id="assign_id">
                                        <option value="0">-Select-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Description</label>
                                    <textarea  class="form-control" name="description" >{{ $task->description  ?? old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="start_date" class="form-label">Start Date
                                    </label>
                                    <input value="{{ $task->start_date ?? old('start_date') }}"
                                        type="date" 
                                        class="form-control" 
                                        name="start_date" 
                                        placeholder="Start Date" >
                                </div>                                
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="end_date" class="form-label">Deadline
                                    </label>
                                    <input value="{{ $task->end_date ?? old('end_date') }}"
                                        type="date" 
                                        class="form-control" 
                                        name="end_date">
                                </div>                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="estimate_time" class="form-label">Estimate Time</label>
                                    <input value="{{ $task->estimate_time  ?? old('estimate_time') }}" 
                                        type="number" 
                                        class="form-control" 
                                        name="estimate_time" 
                                        placeholder="Estimate Time" >
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Days/Hours</label>
                                    <select name="estimate_type"  class="form-select">
                                        <option value="days" {{ (isset($task->estimate_type) && ($task->estimate_type == 'days')) ? 'selected':''}}>Days</option>
                                        <option value="hours" {{ (isset($task->estimate_type) && ($task->estimate_type == 'hours')) ? 'selected':''}}>Hours</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Status</label>
                                    <select name="task_status_id"  class="form-select">
                                        @foreach ($statuses as $status)
                                        <option value="{{$status->id}}" {{ (isset($task->task_status_id) && ($task->task_status_id ==$status->id )) ? 'selected':''}}>{{$status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if (isset($disp) && $disp =='1')
                                <button type="submit" class="btn btn-primary">Save</button>
                            @endif
                            <a href="{{ route('admin.tasks.index') }}" class="btn btn-default">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection
@section('script')
<script>
    
    function getUsers(){
        let project_id = $("#project_id").val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type: "post",
            url : "{{route('admin.project-user')}}",
            data:{
                project_id
            },
            success:function(response){
                $("#assign_id").html(response.data);
            }
        })

        $("#assign_id").val("{{$task->assign_id ?? 0}}");
    }
    getUsers();

    

</script>
    <script src="{{asset('assets/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
@endsection