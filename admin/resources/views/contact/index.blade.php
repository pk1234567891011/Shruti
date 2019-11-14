@extends('admin.admin_template')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="pull-right">
            <div id="dash">
            	Dashboard > Contact Management
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
        <form method="get" action="/contactsearch">
            <input type="search" name="search" class="form-control" id="search"> 
            <button type="submit" id="btnSearch" class="btn btn-primary"  >Search</button>
        </form>
    </div>
</div>
@if($contact_details->isEmpty())
@else
	<div style="left: 200px;" class="table_div">
		<table class="table table-bordered" >
			<tr>
				<th> Id</th>
				<th>UserName</th>
				<th>Email</th>
				<th>Contact</th>
				<th>message</th>
				<th>Admin Note</th>
				<th width="200px">ACTION</th>
			</tr>
			@foreach($contact_details as $contact)
				<tr>
					<td>{{$contact->id}}</td>
					<td>{{$contact->name}}</td>
					<td>{{$contact->email}}</td>
					<td>{{$contact->contact_no}}</td>
					<td>{{$contact->message}}</td>
					<td>{{$contact->note_admin}}</td>
					<td>
						<a class="btn btn-xs btn-info" href="{{route('contact.edit',$contact->id)}}">Reply</a>
						{!! Form::open(['method'=>'DELETE','route'=>['contact.destroy',$contact->id],'style'=>'display:inline'])!!}
						{!! Form::submit('Delete',['class'=>'btn btn-xs btn-danger']) !!}
						{!! Form::close()!!}
					</td>
				</tr>
			@endforeach
		</table>
		{!! $contact_details->links() !!}
	</div>
@endif
@endsection
