@extends('frontend.home')
@section('content')

    <section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
                <li><a href="{{url('homes')}}">Home</a></li>
				  <li href="{{url('orders')}}">Order</li>
                  <!-- <li href="#">{{$orderDetails->id}}</li> -->
				</ol>
			</div>
		</div>
	</section> 
	<section id="do_action">
		<div class="container">
			<div class="heading">
                <table class="table table-bordered" style="font-size:11px">
                    <tr>
                        <th >Quantity</th>
                        <th >Amount</th>
                       
                    </tr>     
                    <tr>
                        @foreach($orderDetails->orders as $pro)
                            <td>{{$pro->quantity}}</td> 
                            <td>{{$pro->amount}}</td>
                        
                    </tr>
                        @endforeach          
                </table>
			</div>
		</div>
	</section><!--/#do_action-->
@endsection
