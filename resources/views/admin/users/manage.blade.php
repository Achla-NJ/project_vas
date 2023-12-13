@extends('admin.layout')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endsection
@section('content')

    <main class="content">
        <div class="mb-3 pt-5 pb-4">
            <h1 class="h3 d-inline align-middle">Manage Users</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
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
                                        <input  
                                            type="text" 
                                            class="form-control" 
                                            name="password" 
                                            placeholder="Password" value="{{ $user->save_password ?? old('save_password') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="username" class="form-label">Role</label>
                                        <select  multiple class="select2 form-select" name="role[]" required id="role" multiple>
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}" {{(isset($userRole) && in_array($role->name,$userRole)) ? 'selected': ''}}>{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="gender" class="form-label">Gender</label>
                                        
                                            <input type="radio" name="gender" value="male" checked="checked" id="gender_male" class="form-check-input" {{ isset($user->gender) && $user->gender == 'male' ? 'checked':''}}>
                                            <label for="gender_male" class="mr15">Male</label> <input type="radio" name="gender" {{ isset($user->gender) && $user->gender == 'female' ? 'checked':''}} value="female" id="gender_female" class="form-check-input">
                                            <label for="gender_female" class="">Female</label>
                                    </div>
                                </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('admin.users.index') }}" class="btn back-btn">Back</a> 
                                </div>
                                <div class="col-6 text-end">
                                    @if (isset($disp) && $disp =='1')
                                        <button type="submit" class="btn btn-success">Save</button>
                                    @endif
                                </div>
                            </div>                            
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if (isset($activities) && count($activities) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body"> 
                        <h4>User History</h4>

                        
                            <x-history :activities="$activities"/>
                        
                            
                        
                    </div>
                </div>
            </div>
        </div>
        @endif

    </main>
    
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script> 
        $('.select2' ).select2( {
            theme: 'bootstrap-5'
        });

        @if (isset($disp) && $disp =='1')
            $("form input").prop("disabled", false);
            $("form textarea").prop("disabled", false);
            $("form select").prop("disabled", false);
            $("form radio").prop("disabled", false);
            $("form checkbox").prop("disabled", false);
            
        @else
            $("form input").prop("disabled", true);
            $("form textarea").prop("disabled", true);
            $("form select").prop("disabled", true);
            $("form radio").prop("disabled", true);
            $("form radio").prop("disabled", true);
            $("form checkbox").prop("disabled", true);

        @endif
    
    </script>
@endsection