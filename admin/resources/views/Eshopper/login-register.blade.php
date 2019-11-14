@extends('frontend.without_login_home')
@section('content')
	@if($message=Session::get('success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p>{{ $message }}</p>
		</div>
	@endif
	@if(Session::has('flash_message_error'))
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p>{!! session('flash_message_error') !!}</p>
		</div>
	@endif
	@if(Session::has('flash_message_success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p>{!! session('flash_message_success') !!}</p>
		</div>
	@endif
	@if(isset(Auth::user()->email))
    	<script>window.location="/login-register/successlogin";</script>
   	@endif

   	@if ($message = Session::get('error'))
		<div class="alert alert-danger alert-block">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<strong>{{ $message }}</strong>
		</div>
   	@endif

   	@if (count($errors) > 0)
		<div class="alert alert-danger">
		<ul>
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
		</ul>
		</div>
   	@endif

	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form id="login" name="login" method="POST" action="{{url('/login-register/checklogin')}}" >
						{{ csrf_field() }}
							<input id="email" name="email" type="email" placeholder="Email Address" required/>
							<input id="password" name="password" type="password" placeholder="Password" />
							
							<button type="submit" class="btn btn-success">Login</button>
							<p></p>
							<a href="{{url('forgot-password')}}">Forgot password ?</a>

                            <a href="{{ url('login/facebook') }}" class="btn btn-primary fa fa-facebook-square fa-2x" style="background-color: #2887ff">   Login With Facebook</a>
							<p></p>
							<a href="{{ url('/redirect') }}"  class="btn btn-primary"  style="background-color: #ff5c33"><i class="fa fa-google-plus-square" aria-hidden="true"></i>
								Login With Google Plus
							</a>
                            <br>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form id="registerForm" name="registerForm" action="{{url('login-register')}}" method="POST">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input id="name" name="name" type="text" placeholder="Name" required>
							<input id="email" name="email" type="email" placeholder="Email Address" required>
							<input id="password" name="password" type="password" placeholder="Password" required>
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
					
				</div>
			</div>
		</div>
	</section><!--/form-->
<script src="{{ asset ('jss/js/jquery.js')}}"></script>
<script src="{{ asset ('jss/js/bootstrap.min.js')}}"></script>
<script src="{{ asset ('jss/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{ asset ('jss/js/price-range.js')}}"></script>
<script src="{{ asset ('jss/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{ asset ('jss/js/main.js')}}"></script>
<script src="{{ asset ('jss/js/jquery.validate.js')}}"></script>
<script src="{{ asset ('jss/js/main.js')}}"></script>
@endsection