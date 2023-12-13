
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    
    <title>{{ env('APP_NAME') }}</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/perfectscroll/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/pace/pace.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/datatables/datatables.min.css')}}" rel="stylesheet">

    
    <!-- Theme Styles -->
    <link href="{{asset('assets/css/main.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/custom.css')}}" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/images/neptune.png')}}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/neptune.png')}}" />
    <link rel="stylesheet" href="{{asset('assets/plugins/toast/css/toastr.min.css')}}">

    @yield('css')
</head>
<body>
    <div class="app align-content-stretch d-flex flex-wrap">
        @include('admin.includes.sidebar')
        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>
                                @php
                                    $roles = auth()->user()->roles;
                                @endphp
                                @if (isset($roles) && count($roles) >1 ) 
                                    @foreach ($roles as $role) 
                                        @if($role->id != session()->get('active_role')['id'] && $role->id != 1)
                                            <li class="nav-item d-flex align-items-center">
                                                
                                                <span class="widget-list-item-description"> 
                                                    <a class="badge badge-success badge-style-light me-3 py-2 form-control-sm" href="{{ route('admin.switch' , $role['slug'])}}"> Switch : {{$role['name']}}</a>
                                                </span>
                                            </li>    
                                        @endif
                                    @endforeach
                                @endif
                                
                            </ul>
            
                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item"> 

                                    <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown">
                                        <span class="badge badge-success badge-style-light form-control-sm me-2 d-none d-lg-inline">{{session()->get('active_role')['name']}}</span>
                                        <img src="{{profile()}}" alt="">
                                        <b>{{ auth()->user()->name}}</b>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
                                        <li class="d-block d-lg-none"><span class="badge badge-success badge-style-light form-control-sm">{{session()->get('active_role')['name']}}</span></li>
                                        <li><a class="dropdown-item" href="{{route('admin.profile')}}">Profile</a></li>
                                        <li><a class="dropdown-item" href="{{route('admin.signout')}}">Log Out</a></li>
                                        
                                    </ul>                                
                                </li>                                
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">
               
                <div class="content-wrapper">
                    <div class="container">
                        @yield('content')
                                              
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Javascripts -->
    <script src="{{asset('assets/plugins/jquery/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/plugins/perfectscroll/perfect-scrollbar.min.js')}}"></script>
    <script src="{{asset('assets/plugins/pace/pace.min.js')}}"></script>
    
    <script src="{{asset('assets/js/main.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/pages/dashboard.js')}}"></script>
	
    <script src="{{asset('assets/plugins/toast/js/toastr.min.js')}}"></script>

    <script src="{{asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/datatables.js')}}"></script>
    <script>
        $.toastr.config({
            time: 5000,
            // more options here
        });
      
      function successToast(msg){
        $.toastr.success(msg);
      }
      
      function errorToast(msg){
        $.toastr.error(msg);
      }
      </script>
      @if (session()->has('success'))
      <script>
        successToast("{{session()->get('success')}}")
      </script>
      @endif
      @if($errors->any())
        @foreach ($errors->all() as $error)
          <script>
            errorToast("{{$error}}")
          </script>
        @endforeach
      @endif
    @yield('script')
    
    </body>
    </html>