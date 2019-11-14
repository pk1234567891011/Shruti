@extends('admin.admin_template')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">
            <div id="dash">
            	Dashboard > User Management
            </div>
        </div>
    </div>
</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="pull-right">
				<div class="create_div" >
				<a  href="{{route('users.create')}}" id="add_cat">Create users</a>
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
	<div id="div_form">
    <form method="get" action="/usersearch">
    <input type="search" name="search" class="form-control" id="search"> 
    <button type="submit" id="btnSearch" class="btn btn-primary"  >Search</button>
    </form>
	</div>
	<div class="table_div">
		<table class="table table-bordered" >
			<tr>

				<th >firstname</th>
				<th >lastname</th>
				<th >email</th>
				<th >status</th>
				<th >role</th>
				<th width="200px">ACTION</th>
			</tr>
			
			@foreach($users as $user)
				<tr>

					<td>{{$user->firstname}}</td>


					<td>{{$user->lastname}}</td>
					<td>{{$user->email}}</td>
					<td>{{$user->status}}</td>
					<td>{{$user->category}}</td>
					<td>
						<a class="btn btn-xs btn-info" href="{{route('users.edit',$user->id)}}">edit</a>
						{!! Form::open(['method'=>'DELETE','route'=>['users.destroy',$user->id],'style'=>'display:inline'])!!}
						{!! Form::submit('Delete',['class'=>'btn btn-xs btn-danger']) !!}
						{!! Form::close()!!}
					</td>


				</tr>
			@endforeach



		</table>
		{!! $users->links() !!}

	</div>

@endsection
