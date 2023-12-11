@extends('admin.layout')
@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="row mb-2 mb-xl-3">
            <div class="col-auto d-none d-sm-block">
                <h3><strong>Dashboard</strong> </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6"> 
                            <p>Login As: {{session()->get('active_role')['name']}}</p>
                            
                            @foreach ($roles as $role) 
                                <a class="btn btn-sm btn-primary me-3" href="{{ route('admin.switch' , $role['slug'])}}">{{$role['name']}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
</main>
@endsection