@extends('frontend.home')
@section('content')
  <div style="background-color: grey;">
    <table style="width:100%">
      <tr>
        <th style="padding-left: 100px;">Order No: {{$order_details->id}}</th>
        <th>Total:{{$order_details->grand_total}}</th>
        <th><h3> Status: <mark>{{$order_details->status}}</h3></mark></th>
        <tr>
    </table>
  </div>

  @if($order_details->status=="pending") 
    @include('steps.pending')
  @elseif($order_details->status=="dispatched")
    @include('steps.dispatched')
  @elseif($order_details->status=="processing")
    @include('steps.processing')
  @elseif($order_details->status=="shipped")
    @include('steps.shipped')
  @else
    @include('steps.delivered')
  @endif
  <div style="height: 112px;">
  </div>
@endsection



