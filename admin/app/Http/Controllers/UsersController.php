<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Address;
use App\DeliveryAddresses;
use App\Cart;
use App\CouponUsed;
use App\Users;
use Auth;
use Hash;
use App\Country;
use App\UserOrder;
use App\OrderDetails;
use DB;
use App\Wishlist;
use App\Roles;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=Users::join('roles', 'users.role_id', '=', 'roles.role_id')
                    ->select('users.*','roles.role_name as category')
                    ->paginate(2);
           
        return view('users.index',compact('users'));
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roles=Roles::orderBy('role_name', 'desc')->get();
        $roles=Roles::all();
        return view('users.create')->with('users', $roles);
    }

    public function search(Request $request){
        $search=$request->search;
        
        $users=Users::where('firstname','like','%'.$search.'%')->paginate(10);
        return view('users.index',compact('users'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'firstname'=>'required|regex:/^[a-zA-Z]+$/',
            'lastname'=>'required|regex:/^[a-zA-Z]+$/',
            'email'=>'required|email|unique:users,email',
            'status'=>'required',
            'role_id'=>'required',
            'password' => 'required|string|min:8|confirmed',
            

        ]);
       
        Users::create($request->all());
        return redirect()->route('users.index')->with('success','category created successfully');

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
        $roles=Roles::all();
        $users = Users::find($id);
        return view('users.edit',compact('users','roles'));

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
        $users = Users::find($id);
        request()->validate([
            'firstname'=>'required|regex:/^[a-zA-Z]+$/',
            'lastname'=>'required|regex:/^[a-zA-Z]+$/',
            'email'=>'required|email',
            'status'=>'required',
            'role_id'=>'required',
            'password' => 'required|string|min:8|confirmed',


        ]);

        Users::find($id)->update($request->all());
        return redirect()->route('users.index')->with('success','user updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_details=Users::find($id);
        Wishlist::where('user_id',$user_details->id)->delete();
        Address::where('userId',$user_details->id)->delete();
        DeliveryAddresses::where('userId',$user_details->id)->delete();
        Cart::where('user_email',$user_details->email)->delete();
        CouponUsed::where('userId',$user_details->id)->delete();
        $user_order =UserOrder::where('user_id',$user_details->id)->delete();
        $user_details->delete();

        return redirect()->route('users.index')->with('success','user deleted successfully');
    }

}
