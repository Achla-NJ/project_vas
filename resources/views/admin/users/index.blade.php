@extends('admin.layout')
@section('css')

@endsection
@section('content')
    <main class="content">
        <div class="d-flex justify-content-between align-items-center mb-3 pt-5 pb-3">
            <h1 class="fw-bold d-inline align-middle">Users</h1>
            <a href="{{ route('admin.users.create') }}"
                class="btn btn-success btn-sm text-right">Add new user</a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table id="datatables-reponsive"  class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                        <span
                                            class="badge bg-success fw-light pt-2">{{ $role->name }}
                                        </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="btn btn-success btn-sm">Show</a>

                                                @can('user_update')
                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                    class="btn btn-info btn-sm">Edit</a>
                                                @endcan
                                                @if($user->id != 37)
                                                    @can('user_delete')
                                                        <form action="{{route('admin.users.destroy',
                                                            $user->id)}}" method="post" onsubmit="return confirm('Are You Sure?')">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                        </form>
                                                    @endcan
                                                @endif
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
@endsection
@section('script')
<script src="{{asset('assets/js/datatables.js')}}"></script>
<script>
    $("#datatables-reponsive").DataTable({
        responsive: true
    });
</script>
@endsection
