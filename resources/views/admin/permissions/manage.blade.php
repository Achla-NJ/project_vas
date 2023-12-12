@extends('admin.layout')
@section('css')
    
@endsection
@section('content')

    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Manage Permissions</h1>
        </div>

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{(isset($permission->id)) ? route('admin.permissions.update',[$permission->id]) : route('admin.permissions.store') }}">
                            @if(isset($permission->id))@method('PUT')@endif
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input value="{{ $permission->name ?? old('name') }}" 
                                    type="text" 
                                    class="form-control" 
                                    name="name" 
                                    placeholder="Name" required>
                
                                @if ($errors->has('name'))
                                    <span class="text-danger text-left">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.permissions.index') }}" class="btn btn-default">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
    
@endsection


