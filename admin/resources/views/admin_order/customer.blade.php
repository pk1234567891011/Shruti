@extends('admin.admin_template')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">
            <div id="dash">
            	Dashboard > Customer Details
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
        <form method="get" action="/customersearch">
            <input type="search" name="search" class="form-control" id="search"> 
            <button type="submit" id="btnSearch" class="btn btn-primary"  >Search</button>
        </form>
    </div>
    @if($customer->isEmpty())
	@else
		<div class="table_div">
			<table class="table table-bordered">
				<tr>
					<th >ID</th>
					<th >User Id</th>
					<th >Address</th>
					<th >city</th>
					<th >state</th>
					<th >country</th>
					<th >pincode</th>
					<th >mobile</th>
				</tr>
				@foreach($customer as $cust)
					<tr>
						<td>{{$cust->id}}</td>
						<td>{{$cust->userId}}</td>
						<td>{{$cust->address}}</td>
						<td>{{$cust->city}}</td>
						<td>{{$cust->state}}</td>
						<td>{{$cust->country}}</td>
						<td>{{$cust->pincode}}</td>
						<td>{{$cust->mobile}}</td>
					</tr>
				@endforeach

			</table>
			{!! $customer->links() !!}
		</div>
	@endif
@endsection
