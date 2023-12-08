<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
    

	<title>@yield('title')</title>

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="{{asset('assets/css/light.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/plugins/toast/css/toastr.min.css')}}">

@yield('css')
</head>


<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
	<div class="wrapper">
		@include('admin.includes.sidebar')

		<div class="main">
			@include('admin.includes.nav')

			@yield('content')
			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a href="https://adminkit.io/" target="_blank" class="text-muted"><strong>AdminKit</strong></a> &copy;
							</p>
						</div>
					
					</div>
				</div>
			</footer>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
	<script src="{{asset('assets/js/app.js')}}"></script>
	
<script src="{{asset('assets/plugins/toast/js/toastr.min.js')}}"></script>

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