@extends('frontend.home')
@section('content')

	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{url('homes')}}">Home</a></li>
				  <li class="active">Thanks</li>
				</ol>
			</div>
		</div>
	</section> 
	<section id="do_action">
		<div class="container" align="center">
			<div class="heading">
				<h3>YOUR ORDER HAS BEEN PLACED</h3>
				<p> Your order number is {{Session::get('order_id') }}
 					and total payable amount is {{Session::get('grand_total')}} 
				</p>
			</div>
		</div>
	</section><!--/#do_action-->
@endsection
<?php
Session::forget('order_id'); 
Session::forget('grand_total'); 

?>