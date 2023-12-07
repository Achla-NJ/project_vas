@extends('admin.layout')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
@endsection
@section('content')
<div class="bg-light  rounded">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Manage Departments</h1>
        </div>

        <div class="row">
            <div class="col-12">
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
                        <form method="POST" action="{{(isset($department->id)) ? route('admin.departments.update',[$department->id]) : route('admin.departments.store') }}">
                            @if(isset($department->id))@method('PUT')@endif
                            @csrf
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input value="{{ $department->name ?? old('name') }}" 
                                        type="text" 
                                        class="form-control" 
                                        name="name" 
                                        placeholder="Name" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="name" class="form-label">Labels</label>
                                    <select name="status[]" class="form-select js-select2" id="multiple-checkboxes" multiple="multiple">
                                        @foreach ($task_statuses as $task_status)
                                            <option value="{{$task_status->id}}" {{(isset($department->status) && in_array($task_status->id,json_decode($department->status))) ? 'selected': ''}}>{{$task_status->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.departments.index') }}" class="btn btn-default">Back</a>
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

