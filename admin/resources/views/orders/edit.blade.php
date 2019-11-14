@extends('admin.admin_template')
@section('content')
    <form action="{{url('order', [$order->id])}}" method="POST">
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
                    <label for="status">status:</label>
                    <select name="status" >
                        <option value="{{$order->status}}" disabled selected>{{$order->status}}</option>
                        <option value="pending">pending</option>
                        <option value="dispatched">dispatched</option>
                        <option value="processing">processing</option>
                        <option value="shipped">shipped</option>
                        <option value="delivered">delivered</option>
                    </select> 
                </div>
            </div>
            <div class="col-xs-12">
                <a class="btn btn-xs btn-success" href="{{route('order.index')}}">Back</a>
                <button type="submit" class="btn btn-xs btn-primary" name="button">Submit</button>
            </div>
        </div>
    </form>
@endsection
