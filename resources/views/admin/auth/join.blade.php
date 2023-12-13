

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <!-- Title -->
    <title>Neptune - Responsive Admin Dashboard Template</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/pace/pace.css')}}" rel="stylesheet">

    
    <!-- Theme Styles -->
    <link href="{{ asset('assets/css/main.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet">

   
</head>
<body>
    <div class="app app-auth-sign-in align-content-center d-flex flex-wrap justify-content-center">
        <div class="app-auth-container text-center">
            <div class="logo mb-3">
                <a href="javascript:void(0)">
                    <img src="{{asset('assets/images/neptune.png')}}" alt="" height="50px" class="me-2">
                    {{ env('APP_NAME') }}</a>
            </div>
            <h3 class="my-3">Login As </h3>
            <div class="d-flex justify-content-center flex-wrap">
                @foreach ($user->roles as $role)
                    @if ($role->id != 1)
                        <a href="{{ route('admin.join-as' , $role->slug)}}"><span class="badge badge-success badge-style-light form-control-lg my-2 login-btn"> {{$role->name}} </span></a>
                    @endif
                @endforeach 
            </div>
        </div>
    </div>
</body>
</html>


 