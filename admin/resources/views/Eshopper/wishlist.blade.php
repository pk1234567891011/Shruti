@extends('frontend.home')
@section('content')
	@if(Session::has('flash_message_success'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p>{!! session('flash_message_success') !!}</p>
		</div>
	@endif
	@if(Session::has('flash_message_error'))
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p>{!! session('flash_message_error') !!}</p>
		</div>
	@endif
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
					<li><a href="{{url('homes')}}">Home</a></li>
					<li class="active">Shopping Cart</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
								
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($userWishlist as $cart)
							<tr>
								<td class="cart_product">
									<a href=""><img src="{{ URL::to('/') }}/products/{{ $cart->image }}" style="height:90%;width:50%" alt=""></a>
								</td>
								<td class="cart_description">
									<h4><a href="">{{$cart->name}}</a></h4>
									<p>Product code: {{$cart->product_code}}</p>
									<p>Price: {{$cart->price}}</p>
									<p><a class="fa fa-trash btn btn-warning" href="{{url('/wishlist/delete-product/'.$cart->id)}}"><i></i> Remove</a></p>
									<p><a class="btn btn-fefault cart" href="{{url('/wishlist/move-product/'.$cart->id)}}"><i class="fa fa-shopping-cart"></i>Move to cart</a></p>
								</td>
							</tr>
						
						@endforeach
							
					</tbody>
				</table>
					
			</div>
		</div>
	</section> <!--/#cart_items-->

	
@endsection