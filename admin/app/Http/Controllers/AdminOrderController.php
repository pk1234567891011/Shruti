<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserOrder;
use App\Address;
use App\Users;
use App\OrderDetails;
class AdminOrderController extends Controller
{
    public function customer()
    {
        $customer=Address::latest()->paginate(6);
        return view('admin_order.customer',compact('customer'));
    }
    public function searchCustomer(Request $request){
        $search=$request->search;
        
        $customer=Address::where('userId','like','%'.$search.'%')->paginate(2);
        return view('admin_order.customer',compact('customer'));

    }

    
    public function orderdetails()
    {
        $order_details=OrderDetails::latest()->paginate(6);
        return view('admin_order.order_details',compact('order_details'));
    }
    public function searchorderdetails(Request $request){
        $search=$request->search;
        
        $order_details=OrderDetails::where('order_id','like','%'.$search.'%')->paginate(2);
        return view('admin_order.order_details',compact('order_details'));

    }
    
    public function userOrder()
    {
        $user_order=UserOrder::latest()->paginate(6);
        return view('admin_order.user_order',compact('user_order'));
    }
    public function searchuserorder(Request $request){
        $search=$request->search;
        
        $user_order=UserOrder::where('user_id','like','%'.$search.'%')->paginate(2);
        return view('admin_order.user_order',compact('user_order'));

    }
}
