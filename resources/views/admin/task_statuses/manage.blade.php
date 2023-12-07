@extends('admin.layout')
@section('css')
    
@endsection
@section('content')
<div class="bg-light  rounded">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Manage Task Status</h1>
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
                        <form method="POST" action="{{(isset($task_status->id)) ? route('admin.task-statuses.update',[$task_status->id]) : route('admin.task-statuses.store') }}">
                            @if(isset($task_status->id))@method('PUT')@endif
                            @csrf
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input value="{{ $task_status->name ?? old('name') }}" 
                                            type="text" 
                                            class="form-control" 
                                            name="name" 
                                            placeholder="Name" required>
                                    </div>
                                    <div class="col-lg-1">
                                        <label for="color" class="form-label">Color</label>
                                        <input value="{{ $task_status->color ?? old('color') }}" 
                                            type="color" 
                                            class="form-control" 
                                            name="color" 
                                            placeholder="Color" required>
                                    </div>
                                </div>
                            </div>
                
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.task-statuses.index') }}" class="btn btn-default">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection


