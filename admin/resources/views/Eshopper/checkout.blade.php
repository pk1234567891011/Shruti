@extends('frontend.home')
@section('content')

	@if(Session::has('flash_message_error'))
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p>{!! session('flash_message_error') !!}</p>
		</div>
	@endif
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{url('homes')}}">Home</a></li>
				<li class="active">Cart</li>
			</ol>
		</div>
		@if(count($errors)>0)
        <div class="alert alert-danger">
            <strong>Whoops!!!</strong> There are some problems with your inputs.</br>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
		<div class="row">
			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form"><!--login form-->
					<h2>Bill To</h2>
					<form action="{{('/checkout')}}" method="post">
					{{ csrf_field() }}
						<input type="text" placeholder="Billing Name" name="billing_name" id="billing_name"  value="{{$userDetails->firstname}}" />
						<input type="text" placeholder="Billing Address" name="billing_address" id="billing_address" @if(!empty($userAddress->address)) value="{{$userAddress->address}}" @endif/>
						<input type="text" placeholder="Billing City" name="billing_city" id="billing_city" @if(!empty($userAddress->city)) value="{{$userAddress->city}}" @endif/>
						<input type="text" placeholder="Billing State" name="billing_state" id="billing_state" @if(!empty($userAddress->state)) value="{{$userAddress->state}}" @endif/>
						<select id="billing_country" name="billing_country">
							<option value="">Select Country</option>
							@foreach($countries as $cont)
								<option value="{{ $cont->country_name}}" @if(!empty($userAddress->country) && $userAddress->country== $cont->country_name)
									selected @endif>{{ $cont->country_name }}
								</option>
							@endforeach
						</select>
						<input type="text" placeholder="Billing Pincode" style="margin-top:10px" name="billing_pincode" id="billing_pincode" @if(!empty($userAddress->pincode)) value="{{$userAddress->pincode}}" @endif/>
						<input type="text" placeholder="Billing Mobile" name="billing_mobile" id="billing_mobile" @if(!empty($userAddress->mobile)) value="{{$userAddress->mobile}}" @endif/>
						<input type="checkbox" id="copyAddress" class="form-check-label"  value="{{$userDetails->firstname}}" />
						<label class="form-check-label" for="copyAddress">Shipping address same as billing address</label>
						<div id="shipping" style="position: absolute;top: -2px;left: 282px;width: 211px;">
							<h2>Ship To</h2>
							<input type="text" placeholder="Shipping Name"  id="shipping_name" name="shipping_name" @if(!empty($shippingDetails->name)) value="{{$shippingDetails->name}}" @endif/>
							<input type="text" placeholder="Shipping Address" id="shipping_address" name="shipping_address" @if(!empty($shippingDetails->address)) value="{{$shippingDetails->address}}" @endif/>
							<input type="text" placeholder="Shipping City" id="shipping_city" name="shipping_city" @if(!empty($shippingDetails->city)) value="{{$shippingDetails->city}}" @endif/>
							<input type="text" placeholder="Shipping State" id="shipping_state" name="shipping_state" @if(!empty($shippingDetails->state)) value="{{$shippingDetails->state}}" @endif/>
							<select id="shipping_country" name="shipping_country">
								<option value="">Select Country</option>
								@foreach($countries as $cont)
									<option value="{{ $cont->country_name}}" @if(!empty($shippingDetails->country) && $shippingDetails->country== $cont->country_name)
										selected @endif>{{ $cont->country_name }}
									</option>
								@endforeach
							</select>                           
							<input type="text" style="margin-top:10px" placeholder="Shipping Pincode" id="shipping_pincode" name="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{$shippingDetails->pincode}}" @endif/>
							<input type="text" placeholder="Shipping Mobile" id="shipping_mobile" name="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{$shippingDetails->mobile}}" @endif/>
							<button type="submit" class="btn btn-default">Checkout</button>
					    </div>
					</form>
				</div><!--/sign up form-->
			</div>
		</div>
	</div>
@endsection
