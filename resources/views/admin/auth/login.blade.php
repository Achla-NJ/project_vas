
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
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="javascript:void(0)">{{ env('APP_NAME') }}</a>
            </div>
            <p class="auth-description">Please sign-in to your account and continue to the dashboard. </p>

			<form action="{{route('signin')}}" method="post">
				@csrf
				@if ($errors->any() || Session::has('error-msg'))
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					<div class="alert-message">
						@foreach ($errors->all() as $error)
							<div>{{$error}}</div>
						@endforeach

						<div> {{ Session::get('error-msg') ?? ''}}</div>
					</div>
				</div>
				@endif
				<div class="mb-3">
					<label class="form-label">Email</label>
					<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
				</div>
				<div class="mb-3">
					<label class="form-label">Password</label>
					<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
					<small>
						<a href="pages-reset-password.html">Forgot password?</a>
					</small>
				</div>
				<div>
					<label class="form-check">
						<input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
						<span class="form-check-label">
							Remember me next time
						</span>
					</label>
				</div>
				<div class="text-center mt-3">
					<button type="submit" class="btn btn-lg btn-success">Sign in</button>
				</div>
			</form>

            
            <div class="divider"></div> 
        </div>
    </div>
</body>
</html>

