@extends('admin.layout')
@section('css')
    
@endsection
@section('content')
<div class="bg-light">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Projects</h1>
            <a href="{{ route('admin.projects.create') }}"
                class="btn btn-primary btn-sm text-right">Add Project</a>
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
                                @foreach ($projects as $key => $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{date('M d, Y',strtotime($project->start_date))}}</td>
                                    <td>{{date('M d, Y',strtotime($project->end_date))}}</td>
                                    <td>{{$project->estimate_time}} {{$project->estimate_type}}</td>
                                    <td>{{ucfirst($project->status)}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-success btn-sm" href="{{ route('admin.projects.show', $project->id) }}">Show</a>
                                            @can('edit_project')
                                            <a class="btn btn-info btn-sm" href="{{ route('admin.projects.edit', $project->id) }}">Edit</a>
                                            @endcan
                                            @can('delete_project')
                                                <form action="{{route('admin.projects.destroy',
                                                $project->id)}}" method="post" onsubmit="return confirm('Are You Sure?')">
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