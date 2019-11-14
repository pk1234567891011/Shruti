@extends('admin.admin_template')
@section('content')
<form action="{{url('contact', [$contact->id])}}" method="POST">
    <input type="hidden" name="_method" value="PUT">
 	  {{csrf_field()}}
 	  @if(count($errors)>0)
      <div class="alert alert-danger">
        <strong>Whoops!!!</strong> There are some problems with your inputs.</br>
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error}}</li>
          @endforeach
        </ul>
      </div>
    @endif
  <div class="row">
    <div class="col-xs-12">
		  <div class="form-group">
			  <label for="message">Message:</label>
            <textarea class="form-control" name="message"  rows="10" cols="10"></textarea>
		  </div>
    </div>
	    <div class="col-xs-12">
        <a class="btn btn-xs btn-success" href="{{route('contact.index')}}">Back</a>
        <button type="submit" class="btn btn-xs btn-primary" name="button">Send</button>
	    </div>
    </div>
  </div>
</form>
@endsection
