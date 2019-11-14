
@extends('frontend.home')
@section('content')
	@include('Eshopper.slider')
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
					<div class="features_items"><!--features_items-->
					
						@if($categoryDetails->parent_id!=0)
							<h2 class="title text-center">{{$categoryDetails->name}}</h2>
							
							@foreach($productsAll as $products)
								@foreach($products->imgs as $img)
									<div class="col-sm-4">
						
		
										<div class="product-image-wrapper">
							
											<div class="single-products">
								        
												<div class="productinfo text-center">
													<img src="{{ URL::to('/') }}/products/{{ $img->image_name }}" height="227px">
			            		@endforeach
													<h2>INR {{$products->price}}</h2>
													<p>{{$products->name}}</p>
													<a href="{{url('prod/'.$products->id )}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>View Details</a>
												</div>
												<div class="product-overlay">
													<div class="overlay-content">
														<h2>INR {{$products->price}}</h2>
														<p>{{$products->name}}</p>
														<a href="{{url('prod/'.$products->id )}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>View Details</a>
													</div>
												</div>
											</div>
										<div class="choose">
											<ul class="nav nav-pills nav-justified">
												
												
											</ul>
										</div>
									</div>
								</div>
						
								@endforeach
								
							
							</div>
							<div align ="center">
								{{ $productsAll->links() }}
							</div>
					
							@else
							<h2 class="title text-center">{{$categoryDetails->name}}</h2>
								@foreach($categories as $products)
									<div class="col-sm-4">
									
					
										<div class="product-image-wrapper">
										
											<div class="single-products">
													
												<div class="productinfo text-center">
													<img src="{{ URL::to('/') }}/products/{{ $products->image }}" height="227px">
						
													<h2>INR {{$products->price}}</h2>
													<p>{{$products->name}}</p>
													<a href="{{url('prod/'.$products->id )}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>View Details</a>
												</div>
												<div class="product-overlay">
													<div class="overlay-content">
														<h2>INR {{$products->price}}</h2>
														<p>{{$products->name}}</p>
														<a href="{{url('prod/'.$products->id )}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>View Details</a>
													</div>
												</div>
											</div>
											<div class="choose">
												<ul class="nav nav-pills nav-justified">
													
												</ul>
											</div>
										</div>
									</div>
								
								@endforeach
						
							
							@endif
					</div>
					
				</div>
			</div>
		</div>
	</section>
@endsection