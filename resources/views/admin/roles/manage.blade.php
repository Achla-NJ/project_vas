@extends('admin.layout')
@section('css')
    
@endsection
@section('content')

    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Manage roles</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{(isset($role->id)) ? route('admin.roles.update',[$role->id]) : route('admin.roles.store') }}">
                            @if(isset($role->id))@method('PUT')@endif
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input value="{{ $role->name  ?? old('name') }}" 
                                    type="text" 
                                    class="form-control" 
                                    name="name" 
                                    placeholder="Name" required readonly>
                            </div>
                            
                            <label for="permissions" class="form-label">Assign Permissions</label>
                
                            <table class="table table-striped">
                                <thead>
                                    <th scope="col" width="1%"><input type="checkbox" name="all_permission" id="checkAll"></th>
                                    <th scope="col" width="20%">Name</th>
                                    <th scope="col" width="1%">Guard</th> 
                                </thead>
                
                                @foreach($permissions as $key=>$permission)
                                
                                    <tr>
                                        <td>
                                            <input type="checkbox" 
                                            name="permission[{{ $permission->name }}]"
                                            value="{{ $permission->name }}"
                                            class='permission' {{(isset($rolePermissions) && in_array($permission->name,$rolePermissions) )? 'checked' : ''}}>
                                        </td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                    </tr>
                                @endforeach
                            </table>
                
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-default">Back</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
    
@endsection
@section('script')
    <script>    
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endsection
