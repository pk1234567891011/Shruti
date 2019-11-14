@extends('admin.admin_template')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">
            <div id="dash">
            	Dashboard > User Order
            </div>
        </div>
    </div>
</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="pull-right">
			
			</div>
		</div>
	</div>
	<div id="div_form">
        <form method="get" action="/userordersearch">
            <input type="search" name="search" class="form-control" id="search"> 
            <button type="submit" id="btnSearch" class="btn btn-primary"  >Search</button>
        </form>
    </div>
    @if($user_order->isEmpty())
	@else
		<div class="table_div">
			<table class="table table-bordered" >
				<tr>
					<th >ID</th>
					<th >User Id</th>
					<th >Shiiping Method</th>
					<th >Grant Total </th>
				</tr>
				@foreach($user_order as $details)
					<tr>
						<td>{{$details->id}}</td>
						<td>{{$details->user_id}}</td>
						<td>{{$details->shipping_method}}</td>
						<td>{{$details->grand_total}}</td>
					</tr>
				@endforeach

			</table>
			{!! $user_order->links() !!}
		</div>
	@endif
@endsection
