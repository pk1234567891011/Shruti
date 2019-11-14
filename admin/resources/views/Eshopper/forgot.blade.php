@extends('frontend.without_login_home')
@section('content')
	@if($message=Session::get('success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×<button>
			<p>{{ $message }}</p>
		</div>
	@endif
	@if(Session::has('flash_message_error'))
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p>{!! session('flash_message_error') !!}</p>
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

   @if(count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
   	@endif
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form"><!--login form-->
					<h2>Forgot Password?</h2>
					<form id="forgotPasswordForm" name="forgotPasswordForm" method="POST" action="{{url('forgot-password')}}" >
					{{ csrf_field() }}
						<input id="email" name="email" type="email" placeholder="Email Address" required/>
							
						<button type="submit" class="btn btn-default">Submit</button>
							
					</form>
				</div><!--/login form-->
			</div>
				
			
		</div>
	</div>

@endsection