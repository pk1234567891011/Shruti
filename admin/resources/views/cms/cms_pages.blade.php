@extends('frontend.home')
@section('content')
<div class="col-sm-9 padding-right">
	<div class="features_items">
	    <h2 class="title text-center">{{$cms_details->title}}</h2>
		<p>{{$cms_details->description}}</p>								
    </div>
</div>
@endsection