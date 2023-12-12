@extends('admin.layout')
@section('css')
    
@endsection
@section('content')

    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Companies</h1>
            <a href="{{ route('admin.companies.create') }}"
                class="btn btn-primary btn-sm text-right">Add Company</a>
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
                                    <th>Company Name</th>
                                    <th>Trade Name</th>
                                    <th>Firm Type</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($companies as $key => $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->company_name }}</td>
                                    <td>{{ $project->trade_name }}</td>
                                    <td>{{ ucwords(str_replace('_',' ',$project->firm_type)) }}</td> 
                                    <td>
                                        <div class="d-flex">
                                            <a class="btn btn-success btn-sm" href="{{ route('admin.companies.show', $project->id) }}">Show</a>
                                            @can('company_update')
                                            <a class="btn btn-info btn-sm" href="{{ route('admin.companies.edit', $project->id) }}">Edit</a>
                                            @endcan
                                            @can('company_delete')
                                                <form action="{{route('admin.companies.destroy',
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

@endsection

@section('script')
<script src="{{asset('assets/js/datatables.js')}}"></script>
<script>
    $("#datatables-reponsive").DataTable({
        responsive: true
    });
</script>
@endsection