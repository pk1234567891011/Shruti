@extends('frontend.home')
@section('content')
	@if(Session::has('flash_message_error'))
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<p>{!! session('flash_message_error') !!}</p>
		</div>
	@endif
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Category</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							<div class="panel panel-default">
              					@foreach($category as $categorys)
              						@if($categorys->children->count())
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordian" href="#{{$categorys->name}}">
													<span class="badge pull-right"><i class="fa fa-plus"></i></span>
													{{$categorys->name}}
												</a>
											</h4>
										</div>
										<div id="{{$categorys->name}}" class="panel-collapse collapse">
											<div class="panel-body">
												<ul>
                    								@foreach($categorys->children as $child)
														<li><a href="{{asset('/products/'.$child->name)}}">{{$child->name}} </a></li>
                      								@endforeach
												</ul>
											</div>
										</div>
               						@else
                						@if($categorys->parent_id==0)
                							<div class="panel-heading">
												<h4 class="panel-title">
													<a data-toggle="collapse" data-parent="#accordian" href="#{{$categorys->name}}">
														<span class="badge pull-right"></span>
														{{$categorys->name}}
													</a>
												</h4>
											</div> 
                						@endif
             						@endif
              					@endforeach

							</div>
						</div>
          			</div>
        		</div>
        
				<div class="col-sm-9 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{ URL::to('/') }}/products/{{ $product_image->image_name }}" alt="" />
								
							</div>
						

						</div>
						<div class="col-sm-7">
                            <form name="addtocartForm" id="addtocartForm" method="POST" action="{{url('add-cart')}}">
							{{ csrf_field() }}
								<input type="hidden" name="product_id" value="{{$productDetails->id}}">
								<input type="hidden" name="product_name" value="{{$productDetails->name}}">
								<input type="hidden" name="price" value="{{$productDetails->price}}">
								
								
								<div class="product-information"><!--/product-information-->
									<img src="{{asset('images/product-details/new.jpg')}}" class="newarrival" alt="" />
									<h2>{{$productDetails->name}}</h2>
									<p>ProductID:{{$productDetails->id}}</p>
									<img src="{{asset('images/product-details/rating.png')}}" alt="" />
									<span>
										<span>INR {{$productDetails->price}}</span>
										<label>Quantity:</label>
										<input type="text" name="quantity" value="1" />
										<button type="submit" class="btn btn-fefault cart" style="margin-left: -14px;margin-top: 14px;">
											<i class="fa fa-shopping-cart"></i>
											Add to cart
										</button>
									</span>
									
									<a href=""><img src="{{asset('images/product-details/share.png')}}" class="share img-responsive"  alt="" /></a>
								</div><!--/product-information-->
							</form>
						</div>
							<form name="addtowishlistForm" id="addtowishlistForm" method="POST" action="{{url('add-wishlist')}}">
							{{ csrf_field() }}
								<input type="hidden" name="product_id" value="{{$productDetails->id}}">
								<input type="hidden" name="quantity" value="1">
								<button type="submit" class="btn btn-fefault cart" style="position: absolute;top: 266px;right: 26px;width: 125px;">
									<i class="fa fa-shopping-cart"></i>
											Add to Wishlist
								</button>
							</form>
						</div>
					</div><!--/product-details-->
				</div>
			</div>
		</div>
    </section>
@endsection