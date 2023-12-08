@extends('admin.layout')
@section('css')
    
@endsection
@section('content')
<div class="bg-light">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Permissions</h1>
            <a href="{{ route('admin.permissions.create') }}"
                class="btn btn-primary btn-sm text-right">Add Permission</a>
        </div>
        <div class="row">
            <div class="col-12"> 
                <div class="card">
                    <div class="card-body">
                        <table id="datatables-reponsive"
                            class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Name</th>
                                    <th>Guard</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                @can('permission_update')
                                                <a class="btn btn-info btn-sm" href="{{ route('admin.permissions.edit', $permission->id) }}">Edit</a>
                                                @endcan
                                                @can('permission_delete')
                                                    <form action="{{route('admin.permissions.destroy',
                                                    $permission->id)}}" method="post" onsubmit="return confirm('Are You Sure?')">
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