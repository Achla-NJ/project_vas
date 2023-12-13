@extends('admin.layout')
@section('content')

<div class="row">
    <div class="col">
        <div class="page-description">
            <h1>Dashboard</h1> 
        </div>
    </div>
</div>
<div class="row">
    {{-- <div class="col-xl-4">
        <div class="card widget widget-list">
            <div class="card-header">
                <h5 class="card-title">Current Role<span class="badge badge-success badge-style-light form-control-sm">{{session()->get('active_role')['name']}}</span></h5>
            </div>
            @if (count($roles) >1 ) 
            <div class="card-body">
                <span class="text-muted m-b-xs d-block">Other User roles:</span>
                <ul class="widget-list-content list-unstyled d-flex">
                    @foreach ($roles as $role) 
                        @if($role->id != session()->get('active_role')['id'])
                            <li class="widget-list-item widget-list-item-green">
                                
                                <span class="widget-list-item-description"> 
                                    <a class="badge badge-success badge-style-light me-3 py-2 form-control-sm" href="{{ route('admin.switch' , $role['slug'])}}"> Switch To : {{$role['name']}}</a>
                                </span>
                            </li>    
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>  --}}
    
    {{-- <div class="col-xl-4">
        <div class="card widget widget-list">
            <div class="card-header">
                <h5 class="card-title">Add Company</h5>
            </div>
            
            <div class="card-body"> 
                @can('company_access')
                    <a href="{{ route('admin.company.index' , 'b2b') }}" class="btn btn-success btn-sm text-right">B2B Company</a>
                @endcan

                @can('company_access')
                    <a href="{{ route('admin.company.index' , 'b2c') }}" class="btn btn-success btn-sm text-right">B2C Company</a>
                @endcan
            </div> 
        </div>
    </div>  --}}
</div> 

@endsection