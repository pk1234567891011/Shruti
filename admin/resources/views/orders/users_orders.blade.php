@extends('frontend.home')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{url('homes')}}">Home</a></li>
				  <li class="active">Order Details</li>
				</ol>
			</div>
		</div>
	</section> 
    @if($orders->isEmpty())
        <span id="order_records">No Orders</span>
    @else
        <section id="do_action">
            <div class="container">
                <div class="heading">
                    <table class="table table-bordered" style="font-size:11px">
                        <tr>
                            <th >Order ID</th>
                            <th>Product ID</th>
                            <th >Payment Method</th>
                            <th >Grand Total</th>
                            <th >Status</th>
                            <th >Ordered on</th> 
                        </tr>  
                        @foreach($orders as $order)   
                            <tr>
                            
                                <td>{{$order->id}}</td> 
                                <td>
                                    @foreach($order->orders as $pro)
                                        <a href="{{url('/orders/'.$order->id)}}"> {{$pro->product_id}}</a><br>
                                    @endforeach
                                </td>
                                <td>{{$order->shipping_method}}</td> 
                                <td>{{$order->grand_total}}</td>
                                <td>{{$order->status}}</td>
                                <td>{{$order->created_at}}</td> 
                            </tr>
                        @endforeach          
                    </table>
                    {{ $orders->links()}}
                </div>
            </div>
        </section><!--/#do_action-->
    @endif
@endsection
