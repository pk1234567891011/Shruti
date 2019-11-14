@extends('admin.admin_template')
@section('content')
<form action="{{url('cms', [$cms->id])}}" method="POST">
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
                <strong>Title :</strong>
                <input type="text" class="form-control" name="title" value="{{$cms->title}}"/>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <strong>Description :</strong>
                <input type="text" class="form-control" name="description" value="{{$cms->description}}"/>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <strong>URL :</strong>
                <input type="text" class="form-control" name="url" value="{{$cms->url}}"/>
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <strong>Status :</strong>
                <select class="form-control" id="status" name="status">
                    @if($cms->status==0)
                    <option value="{{$cms->status}}" disabled="" selected="">
                      InActive</option>
                      @else
                    <option value="{{$cms->status}}" disabled="" selected="">
                      Active</option>
                      @endif
                    </option>
                    <option value="0">InActive</option>
                    <option value="1">Active</option>
                    </select>
            </div>
        </div>
        <div class="col-xs-12">
            <a class="btn btn-xs btn-success" href="{{route('cms.index')}}">Back</a>
            <button type="submit" class="btn btn-xs btn-primary" name="button">Submit</button>
        </div>
    </div>
</form>
@endsection
