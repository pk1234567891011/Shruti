@extends('admin.admin_template')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="pull-right">

            </div>
        </div>
    </div>
    @if(Session::has('flash_message_success'))
        <div class="alert alert-success">
            <p>{!! session('flash_message_success') !!}</p>
        </div>
    @endif
    <div>
        <a href="{{url('export-newsletter-email')}}" class="btn btn-primary btn-mini">Export</a>
    </div>
    <div style="position: absolute;top: 191px;">
        <table class="table table-bordered" >
            <tr>

                <th > Email</th>
                <th >status</th>
                <th>Action</th>
            </tr>
            @foreach($newsletter as $news)
                <tr>
                    <td>{{$news->email}}</td>
                    @if($news->status==1)
                        <td><a href="{{url('update-newsletter-status/'.$news->id.'/0')}}"><span>Active</span></a></td>
                    @else
                        <td><a href="{{url('update-newsletter-status/'.$news->id.'/1')}}"><span>InActive</span></a></td>
                    @endif
                    <td><a class="btn btn-xs btn-danger" href="{{url('delete-newsletter-email/'.$news->id)}}"><span>Delete</span></a></td>

                </tr>
            @endforeach

        </table>


    </div>
@endsection
