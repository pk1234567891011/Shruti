@extends('admin.admin_template')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">
            <div id="dash">
            	Dashboard > Configuration Management
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">
            <div class="create_div">
            <a  href="{{route('configuration.create')}}" id="add_cat">Create Configuration</a>
            </div>
        </div>
    </div>
</div>
@if($message=Session::get('success'))
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<p>{{ $message }}</p>
	</div>
@endif
@if($configuration->isEmpty())
@else
	<div class="table_div">
		<table class="table table-bordered" >
			<tr>
				<th >Config Key</th>
				<th >Config Value</th>
				<th >status</th>
				<th width="200px">ACTION</th>
			</tr>
			@foreach($configuration as $configurationss)
				<tr>
					<td>{{$configurationss->conf_key}}</td>
					<td>{{$configurationss->conf_value}}</td>
					<td>{{$configurationss->status}}</td>
					<td>
						<a class="btn btn-xs btn-info" href="{{route('configuration.edit',$configurationss->id)}}">edit</a>
						{!! Form::open(['method'=>'DELETE','route'=>['configuration.destroy',$configurationss->id],'style'=>'display:inline'])!!}
						{!! Form::submit('Delete',['class'=>'btn btn-xs btn-danger']) !!}
						{!! Form::close()!!}
					</td>
				</tr>
			@endforeach

		</table>
		{!! $configuration->links() !!}
	</div>
@endif
@endsection
