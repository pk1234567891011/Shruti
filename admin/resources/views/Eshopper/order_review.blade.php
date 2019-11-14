@extends('frontend.home')
@section('content')

<section id="cart_items">
	<div class="container">
        <div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{url('homes')}}">Home</a></li>
				<li class="active">Order Review</li>
			</ol>
		</div>
    <div class="row">
		<div class="col-sm-4 col-sm-offset-1">
			<div class="login-form"><!--login form-->
                <h2>Billing Address</h2>
                <div class="form-group">
                    {{$userDetails->firstname}}
                </div>
                <div class="form-group">
                    {{$userAddress->address}}
                </div>
                <div class="form-group">
                    {{$userAddress->city}}
                </div>
                <div class="form-group">
                    {{$userAddress->state}}
                </div>
                <div class="form-group">
                    {{$userAddress->country}}
                </div>
                <div class="form-group">
                    {{$userAddress->pincode}}
                </div>
                <div class="form-group">
                    {{$userAddress->mobile}}
                </div>
                <div class="form-group">
                    {{$userDetails->firstname}}
                </div>

				<div id="shipping" style="position: absolute;top: -2px;left: 282px;width: 211px;">
                    <h2>Shipping Address</h2>
                    <div class="form-group">
                        {{$shippingDetails->name}}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->address}}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->city}}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->state}}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->country }}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->pincode}}
                    </div>
                    <div class="form-group">
                        {{$shippingDetails->mobile}}
                    </div>

				</div><!--/sign up form-->
			</div>
		</div>
	</div>
</div>
<div class="review-payment">
	<h2>Review & Payment</h2>
</div>
<div class="table-responsive cart_info">
	<table class="table table-condensed">
		<thead>
			<tr class="cart_menu">
				<td class="image">Item</td>
				<td class="description"></td>
				<td class="price">Price</td>
				<td class="quantity">Quantity</td>
				<td class="total">Total</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
    	<?php $total_amount = 0;?>
        @foreach($userCart as $cart)
			<tr>
				<td class="cart_product">
					<a href=""><img src="{{ URL::to('/') }}/products/{{ $cart->image }}" style="height:100px;width:80px" alt=""></a>
				</td>
				<td class="cart_description">
					<h4><a href="">{{$cart->product_name}}</a></h4>
					<p>Web ID: 1089772</p>
				</td>
				<td class="cart_price">
					<p>INR{{$cart->price}}</p>
				</td>
				<td class="cart_quantity">
					<div class="cart_quantity_button">
						{{$cart->quantity}}
					</div>
				</td>
				<td class="cart_total">
					<p class="cart_total_price">INR {{$cart->price*$cart->quantity}}</p>
				</td>
				
			</tr>
            <?php $total_amount = $total_amount + ($cart->price * $cart->quantity);?>
            @endforeach
			<tr>
				<td colspan="4">&nbsp;</td>
				<td colspan="2">
					<table class="table table-condensed total-result">
						<tr>
							<td>Cart Sub Total</td>
							<td>INR {{$total_amount}}</td>
						</tr>
						@if($total_amount>500)
						<tr class="shipping-cost">
							<td>Shipping Cost</td>
							<td>Free</td>
						</tr>
						@else
						<tr class="shipping-cost">
							<td>Shipping Cost</td>
							<td>INR 50</td>
						</tr>
						@endif
						<tr class="shipping-cost">
                            <td>Discount Amount</td>
                            <td>
                                @if(!empty(Session::get('CouponAmount')))
                                	INR {{Session::get('CouponAmount')}}
                                @else
                                    INR 0
                                @endif
                            </td>

						</tr>
						@if($total_amount>500)
						<tr>
							<td>Grand Total</td>
							<td><span>{{$grand_total=$total_amount-Session::get('CouponAmount')}}</span></td>
						</tr>
						@else
						<tr>
							<td>Grand Total</td>
							<td><span>{{$grand_total=$total_amount-Session::get('CouponAmount')+50}}</span></td>
						</tr>
						@endif
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<form name="paymentForm" id="paymentForm"  method="post" action="{{url('/place-order')}}">
	{{ csrf_field() }}
	<input type="hidden" name="grand_total" value="{{$grand_total}}" />
	<div class="payment-options">
		<span>
			<label><strong>Select payment option<strong></label>
			<br>
		</span>
		<span>
			<label><input type="radio" name="payment_method" id="COD" value="COD">Cash on delivery</label>
		</span>
		<span>
			<label><input type="radio" name="payment_method" id="paypal" value="paypal"> Paypal</label>
		</span>
		<span style="float:right">
			<button  type="submit" class="btn btn-default" onclick="return selectPaymentmMethod();">Place Order</button>
		</span>
	</div>
</form>
</section>

@endsection