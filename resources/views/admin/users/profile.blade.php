@extends('admin.layout')
@section('css')
    
@endsection
@section('content')

    <main class="content pt-5">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Profile</h1>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.update-profile')}}" enctype="multipart/form-data">
                            @csrf
                                <div class="row ">
                                    <div class="col-lg-12 mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input value="{{ $user->name ?? old('name') }}" 
                                            type="text" readonly
                                            class="form-control" 
                                            name="name" 
                                            placeholder="Name" required>
                                    </div>         
                                    <div class="col-lg-12 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input value="{{ $user->email ?? old('email') }}"
                                            type="email" 
                                            class="form-control" 
                                            name="email"  readonly
                                            placeholder="Email address" required>
                                    </div>
                                    
                                    <div class="col-lg-12 mb-3">
                                        <label for="file" class="form-label">Profile</label>
                                        <input  
                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                            type="file" 
                                            class="form-control" 
                                            name="file"   >
                                    </div>

                                    <img id="blah" src="{{profile()}}" alt="your image" style="width: 100px;"  class="my-2"/>
                                </div> 
                                <button type="submit" class="btn btn-success">Save</button>                      
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
    
@endsection

@section('script')

@endsection