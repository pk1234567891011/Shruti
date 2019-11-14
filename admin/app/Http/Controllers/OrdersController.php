<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Http\Request;
use App\UserOrder;
use App\Address;
use App\Users;
use App\OrderDetails;
class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $order_details=UserOrder::latest()->paginate(2);;
        return view('orders.index',compact('order_details'));
    }
    
    public function search(Request $request){
        $search=$request->search;
        
        $order_details=UserOrder::where('id','like','%'.$search.'%')->paginate(2);
        return view('orders.index',compact('order_details'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=UserOrder::find($id);
        return view('orders.edit',compact('order'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status'=>'required',
        ]);
        $user_details=UserOrder::find($id);
        $productDetails=UserOrder::with('orders')->where('id',$id)->first();
        $productDetails=json_decode(json_encode($productDetails),true);
        $user_addresss=Address::where('userId', $user_details->user_id)->first();
        $user=Users::where('id', $user_details->user_id)->first();
        $email=$user->email;
        $mytime =date("Y-m-d h:i:s a", time());
        $messageData=[

            'productDetails'=>$productDetails,
            'user_addresss'=>$user_addresss,
            'mytime'=>$mytime,
            'order_id'=>$user_details->id
            ];
          
        Mail::send('emails.status', $messageData,function ($message) use ($email) {
                $message->to($email)->subject('Order Details');
            });
        UserOrder::find($id)->update($request->all());
        return redirect()->route('order.index')->with('success','status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
