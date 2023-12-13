@extends('admin.layout')
@section('css')

@endsection
@section('content')
<main class="content">
    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Roles</h1>
        {{-- <a href="{{ route('admin.roles.create') }}" class="btn btn-success
        btn-sm text-right">Add Role</a> --}}
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatables-reponsive" class="table table-striped"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr No.</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                            @if ($role->id != 1)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <div class="d-flex">
                                        @can('role_update')
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('admin.roles.edit', $role->id) }}">Edit</a>

                                        @endcan
                                        @can('role_delete')
                                        <form action="{{route('admin.roles.destroy',
                                                    $role->id)}}" method="post"
                                            onsubmit="return confirm('Are You Sure?')">
                                            @csrf
                                            @method('DELETE')

                                            {{-- <button type="submit" class="btn btn-danger btn-sm">Delete</button>     --}}
                                        </form>

                                        @endcan
                                    </div>

                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>

@endsection
@section('script')
<script src="{{asset('assets/js/datatables.js')}}"></script>
<script>
    $("#datatables-reponsive").DataTable({
        responsive: true
    });
</script>
@endsection