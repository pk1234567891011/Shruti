<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use App\Users;
use App\Roles;
use Hash;
class MainController extends Controller
{
    function index()
    {   
        return view('login');
    }
    function checklogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password'  => 'required'
        ]);
        
        $user_details=Users::where('email' ,$request->get('email'))->first();
        if(!empty( $user_details)){
            if (Hash::check($request->password,$user_details->password)) {
                $role=Roles::where('role_id',$user_details->role_id)->first();
                $user_data = array(
                    'email'  => $request->get('email'),
                    'password' => $request->get('password')
                );
                if($role->role_id==1 || $role->role_id==2){
                    if (Auth::attempt($user_data)) {
                        Session::put('adminSession', $user_data['email']);
                        return view('admin.admin_template');
                    } 
                    else
                    {
                        return back()->with('error', 'Wrong Login Details');
                    }
                }
                else{
                    return back()->with('error', 'You don/t have Permission ');
                }
            }
            else{
                return back()->with('error', 'Wrong Login Details');

            }
        }
        else {
            return back()->with('error', 'Email does not exists'); 
        }
    }

    function successlogin()
    {
        return view('admin.admin_template');
    }

    function logout()
    {   
        Session::forget('adminSession');
        Auth::logout();
        return view('login');
    }
}
