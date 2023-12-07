@extends('admin.layout')
@section('css')
    
@endsection
@section('content')
<div class="bg-light  rounded">
    <main class="content">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Manage Users</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon">
                                <i class="far fa-fw fa-bell"></i>
                            </div>
                            <div class="alert-message">
                                <ul>
                                @foreach ($errors as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                            </div>
                        </div>
                            
                        @endif
                        <form method="POST" action="{{(isset($user->id)) ? route('admin.users.update',[$user->id]) : route('admin.users.store') }}">
                            @if(isset($user->id))@method('PUT')@endif
                            @csrf
                            
                                <h4>General Info</h4>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input value="{{ $user->name ?? old('name') }}" 
                                            type="text" 
                                            class="form-control" 
                                            name="name" 
                                            placeholder="Name" required>
                                    </div>         
                                    <div class="col-lg-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input value="{{ $user->email ?? old('email') }}"
                                            type="email" 
                                            class="form-control" 
                                            name="email" 
                                            placeholder="Email address" required>
                                    </div>                           
                                </div>
                                <div class="row mb-3">
                                    
                                    <div class="col-lg-6">
                                        <label for="mobile" class="form-label">Mobile</label>
                                        <input value="{{ $user->mobile ?? old('mobile') }}"
                                            type="number" 
                                            class="form-control" 
                                            name="mobile" 
                                            placeholder="Mobile" required>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="email" class="form-label">Password</label>
                                        <input value=""
                                            type="password" 
                                            class="form-control" 
                                            name="password" 
                                            placeholder="Password" >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="username" class="form-label">Role</label>
                                        <select class="form-select" name="role" required id="role">
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}" {{(isset($userRole) && in_array($role->name,$userRole)) ? 'selected': ''}}>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="gender" class="form-label">Gender</label>
                                        
                                            <input type="radio" name="gender" value="male" checked="checked" id="gender_male" class="form-check-input">
                                            <label for="gender_male" class="mr15">Male</label> <input type="radio" name="gender" value="female" id="gender_female" class="form-check-input">
                                            <label for="gender_female" class="">Female</label>
                                    </div>
                                </div>
                                
                                <h4> Job Info</h4>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="name" class="form-label">Job Title</label>
                                        <input value="{{ $user->job_title ?? old('job_title') }}" 
                                            type="text" 
                                            class="form-control" 
                                            name="job_title" 
                                            placeholder="Job Title" required>
                                    </div>        
                                    <div class="col-lg-6">
                                        <label for="name" class="form-label">Salary</label>
                                        <input value="{{ $user->salary ?? old('salary') }}" 
                                            type="text" 
                                            class="form-control" 
                                            name="salary" 
                                            placeholder="Salary" required>
                                    </div>                                
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="date_of_hire" class="form-label">Date of hire
                                        </label>
                                        <input value="{{ $user->date_of_hire ?? old('date_of_hire') }}"
                                            type="date" 
                                            class="form-control" 
                                            name="date_of_hire" 
                                            placeholder="Date of hire" >
                                    </div>
                                    <div class="col-lg-6 {{isset($userRole) && $userRole[0] == 'user' ? '' : 'd-none'}}" id="department_id">
                                        <label for="department_id" class="form-label">Department
                                        </label>
                                        <select  class="form-select"  name="department_id" >
                                            <option value="">-Select-</option>
                                            @foreach ($departments as $department)
                                                <option value="{{$department->id}}" {{(isset($user->department_id ) && $department->id == $user->department_id) ? 'selected': ''}}>{{$department->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @if (isset($disp) && $disp =='1')
                                <button type="submit" class="btn btn-primary">Save</button>
                            @endif
                            <a href="{{ route('admin.users.index') }}" class="btn btn-default">Back</a>                           
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>
@endsection

@section('script')
<script>
    $("#role").on('change',function(){
        if($("#role").val()=='3'){
            $("#department_id").removeClass('d-none');
        }else{
            $("#department_id").addClass('d-none');
        }
    });
</script>
@endsection