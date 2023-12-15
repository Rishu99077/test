<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link href="{{ asset('adminassets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('adminassets/css/loginpage.css') }}">
</head>
<body>
	<div class="row justify-content-center g-0 ">
    </div>
	<div class="login-page">
		<div class="form">
	        <div class="col-lg-9 col-xl-7 col-xxl-7">
	            <a class="d-flex flex-center mb-4" href="javascript:void(0)">
	                <img class="me-2 w-50" src="{{ asset('adminassets/img/logo.png') }}" alt="" width="50" style="margin: 0 auto;">
	            </a>
	        </div>
			<form class="md-float-material" method="post" action="{{ route('dologin') }}">
                 @csrf
				<div class="form-group" id="Input-username">
					<label>Email ID / Username <span class="text-danger">*</span> </label>
					<input type="text" name="email" placeholder="Email ID or Username" class="form-control" value="{{ old('email') }}">
					<div class="text-danger">
						@if ($errors->has('email'))
	                        {{ $errors->first('email') }}
	                    @endif
	                </div>
				</div>

				<div class="form-group" id="Input-password">
					<label>Password <span class="text-danger">*</span> </label>
					<input type="password" name="password" placeholder="Password" class="form-control" value="{{ old('password') }}">
					<div class="text-danger">
						@if ($errors->has('password'))
	                        {{ $errors->first('password') }}
	                    @endif
	                </div>
				</div>
				<button type="submit">Login</button>
			</form>
		</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<script src="{{ asset('adminassets/js/alert.js') }}"></script>
	<script src="{{ asset('adminassets/js/notify.js') }}"></script>
    <script src="{{ asset('adminassets/js/notify.min.js') }}"></script>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	@if ($errors->has('success'))
	   <script>
	       success_msg("{{ $errors->first('success') }}")
	   </script>
	@endif
	@if ($errors->has('error'))
	   <script>
	       danger_msg("{{ $errors->first('error') }}");
	   </script>
	@endif
	
</body>
</html>