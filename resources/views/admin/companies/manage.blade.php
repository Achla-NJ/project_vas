@extends('admin.layout')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endsection
@section('content')
<div class="bg-light  rounded">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Manage Project</h1>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">                        
                        <form method="POST" action="{{(isset($project->id)) ? route('admin.projects.update',[$project->id]) : route('admin.projects.store') }}">
                            @if(isset($project->id))@method('PUT')@endif
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Title</label>
                                    <input value="{{ $project->name  ?? old('name') }}" 
                                        type="text" 
                                        class="form-control" 
                                        name="name" 
                                        placeholder="Title" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Client</label>
                                    <select name="client_id" class="form-select" >
                                        <option value="">-Select-</option>
                                        @foreach ($clients as $client)
                                            <option value="{{$client->id}}" {{ (isset($project->client_id) && ($project->client_id == $client->id)) ? 'selected':''}}>{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Description</label>
                                    <textarea  class="form-control" name="description" required>{{ $project->description  ?? old('description') }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <label for="start_date" class="form-label">Start Date
                                    </label>
                                    <input value="{{ $project->start_date ?? old('start_date') }}"
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
                                    <input value="{{ $project->end_date ?? old('end_date') }}"
                                        type="date" 
                                        class="form-control" 
                                        name="end_date">
                                </div>                                
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="estimate_time" class="form-label">Estimate Time</label>
                                    <input value="{{ $project->estimate_time  ?? old('estimate_time') }}" 
                                        type="number" 
                                        class="form-control" 
                                        name="estimate_time" 
                                        placeholder="Estimate Time" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Days/Hours</label>
                                    <select name="estimate_type"  class="form-select">
                                        <option value="days" {{ (isset($project->estimate_type) && ($project->estimate_type == 'days')) ? 'selected':''}}>Days</option>
                                        <option value="hours" {{ (isset($project->estimate_type) && ($project->estimate_type == 'hours')) ? 'selected':''}}>Hours</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Users</label>
                                    <select name="users[]" class="form-select js-select2" id="multiple-checkboxes" multiple="multiple">
                                        <option value="">-Select-</option>
                                        @foreach ($users as $key=> $user)
                                            <option value="{{$user->id}}" {{ (isset($project_users[$key]) && $project_users[$key]->user_id == $user->id) ? 'selected':''}}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Status</label>
                                    <select name="status"  class="form-select">
                                        <option value="open" {{ (isset($project->status) && ($project->status == 'open')) ? 'selected':''}}>Open</option>
                                        <option value="completed" {{ (isset($project->status) && ($project->status == 'completed')) ? 'selected':''}}>Completed</option>
                                        <option value="hold" {{ (isset($project->status) && ($project->status == 'hold')) ? 'selected':''}}>Hold</option>
                                        <option value="canceled" {{ (isset($project->status) && ($project->status == 'canceled')) ? 'selected':''}}>Canceled</option>
                                    </select>
                                </div>
                            </div>
                            @if (isset($disp) && $disp =='1')
                                <button type="submit" class="btn btn-primary">Save</button>
                            @endif
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-default">Back</a>
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
@endsection