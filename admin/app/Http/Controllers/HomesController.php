<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Exception;
namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Address;
use App\Banner;
use App\DeliveryAddresses;
use App\Cart;
use App\Category;
use App\Coupon;
use App\CouponUsed;
use App\Product;
use App\Product_attributes;
use App\Product_attributes_assoc;
use App\Product_attribute_values;
use App\Product_categories;
use App\Product_images;
use App\Users;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Mail;
use Session;
use App\Country;
use App\UserOrder;
use App\OrderDetails;
use DB;
use App\Wishlist;
use App\Contact;
class HomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function slider()
    {
        $sliders = Banner::where('status','active')->orderby('id', 'desc')->get();
        return view('Eshopper.slider', compact('sliders'));
    }
    public function index()
    {   
        $category = Category::with('children')->where('status','active')->get();
        $sliders = Banner::where('status','active')->orderby('id', 'desc')->get();
        $images = Product_images::where('status', 'active')->get();
        $productsAll = Product::has('imgs')->orderBy('id','DESC')->paginate(4);
        
        return view('Eshopper.first', compact('sliders', 'category', 'images', 'productsAll','paginate'));

    }
    public function allsearch(Request $request){
        $search=$request->search;
        $category = Category::with('children')->where('status','active')->get();
        $sliders = Banner::where('status','active')->orderby('id', 'desc')->get();
        $images = Product_images::where('status', 'active')->get();
        $productsAll = Product::has('imgs')->where('name','like','%'.$search.'%')->orderBy('id','DESC')->paginate(4);
        return view('Eshopper.first', compact('sliders', 'category', 'images', 'productsAll','paginate'));

    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',

            ]);
        $data = $request->all();
        $usersCount = Users::where('email', $data['email'])->count();
        if ($usersCount > 0) {
            return redirect()->back()->with('flash_message_error', 'Email already exists');
        } 
        else {
            $email=$data['email'];
            $messageData=[
                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>$data['password'],
                ];
            Mail::send('emails.register', $messageData, function ($message) use ($email) {
                    $message->to($email)->subject('Registration successful');
                });
            Mail::send('emails.admin', $messageData, function ($message) use ($email) {
                    $message->to("kumaripri6@gmail.com")->subject('User Details');
                });
            $user = new Users();
            $user->firstname = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->role_id = 5;
            $user->save();
                
            $user_data = array(
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                );
                
            if (Auth::attempt($user_data)) {
                Session::put('frontSession', $user_data['email']);
                return redirect('homes');
                }
               
                
            }
        }
        return view('Eshopper.login-register');

    }
    public function forgotPassword(Request $request)
    {   if ($request->isMethod('post')) {
            $data = $request->all();
            $usersCount = Users::where('email', $data['email'])->count();
            if ($usersCount == 0) {
                return redirect()->back()->with('flash_message_error', 'Email does not exists');
            }
            $userDetail = Users::where('email', $data['email'])->first();
            $random_password = str_random(8);
            $new_password = bcrypt($random_password);
            Users::where('email', $data['email'])->update(['password' => $new_password]);
            $email = $data['email'];

            $name = $userDetail->name;
            $messageData = [
                'email' => $email,
                'name' => $name,
                'password' => $random_password,
            ];
            Mail::send('emails.forgotpassword', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('New Password');

            });
            return redirect('login-register')->with('flash_message_success', 'Check your email for new password');
        }
        return view('Eshopper.forgot');
    }
    public function checkslogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user_data = array(
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        );

        if (Auth::attempt($user_data)) {
            Session::put('frontSession', $user_data['email']);
            return redirect('homes');
        } 
        else {
            return back()->with('error', 'Wrong Login Details');
        }

    }

    public function successlogins()
    {
        return redirect('homes');
    }
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {  
            $facebookUser = Socialite::driver('facebook')->stateless()->user();
            $existUser = Users::where('email',$facebookUser->email)->first();
            
            // echo "try";
            // die;
            if($existUser) {
                Auth::loginUsingId($existUser->id);
                Session::put('frontSession', $facebookUser->email);

            }
            else {
                   $user = new Users;
                   $user->firstname= $facebookUser->name;
                   $user->email= $facebookUser->email;
                   $user->password= bcrypt(123456789);
                   $user->status= "active";
                   $user->role_id=5;
                   $user->save();
                Auth::loginUsingId($user->id);
                Session::put('frontSession',$facebookUser->email);

            }
            return redirect()->to('/homes');
        
    }
   public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }


    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        $existUser = Users::where('email',$googleUser->email)->first();
            
        if($existUser) {
            Auth::loginUsingId($existUser->id);
            Session::put('frontSession', $googleUser->email);

        }
        else {
            $user = new Users;
            $user->firstname= $googleUser->name;
            $user->email= $googleUser->email;
            $user->password= bcrypt(123456789);
            $user->status= "active";
            $user->role_id=5;
            $user->save();
            Auth::loginUsingId($user->id);
            Session::put('frontSession',$googleUser->email);
        }
        return redirect()->to('/homes');
       
    }
    public function logouts()
    {
        Auth::logout();
        Session::forget('frontSession');
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        return redirect('login-register');
    }
    public function products($url = null)
    {   
        $categoryDetails = Category::where(['name' => $url])->first();
        $categoryCount = Category::where(['name' => $url])->count();
        if ($categoryCount == 0) {
            abort(404);
        }
        $sliders = Banner::where('status','active')->orderby('id', 'desc')->get();
        
        if ($categoryDetails->parent_id == 0) {
            $subCategories = Category::where(['parent_id' => $categoryDetails->id,'status'=>'active'])->get();

            $cat_ids = "";
            foreach ($subCategories as $subCat) {
                $cat_ids[]= $subCat->id . ",";
            }
            $categories=Product_Categories::whereIn('category_id', $cat_ids)->orderBy('id','DESC')->get();
            foreach ($categories as $key => $product) {
                $productDetail = Product::where('id', $product->product_id)->first();
                $image = Product_images::where('product_id', $productDetail->id)->first();
                $categories[$key]->image = $image->image_name;
                $categories[$key]->name = $productDetail->name;
                $categories[$key]->price = $productDetail->price;
            }
         
            $category = Category::with('children')->where('status','active')->get();
        } 
        else{
          
            $productCat = Product_categories::where(['category_id' => $categoryDetails->id])->get();
            $productsAll = Product::whereIn('id', $productCat->pluck('product_id'))->orderBy('id','DESC')->paginate(4);
            $category = Category::with('children')->get();

        }
        return view('Eshopper.listing', compact('productsAll','paginate', 'product', 'image', 'categories','sliders', 'category', 'categoryDetails'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 
    public function prod($id)
    {
        $productDetails = Product::where('id', $id)->first();
         
        $category = Category::with('children')->get();
        $sliders = Banner::orderby('id', 'desc')->paginate(10);

        $productsAll = Product::has('imgs')->get();
        $product_image = Product_images::where('product_id', $productDetails->id)->first();
        return view('Eshopper.details')->with(compact('category', 'productDetails', 'product_image', 'product_attributes', 'product_attribute_value','recommended'));
    }
    public function account(Request $request)
    {   
        $user_id = Auth::user()->id;
        $add = Address::where('userId', $user_id)->get();
        $paginate = Address::latest()->paginate(15);
        $userInfo = Users::where('id', $user_id)->first();
        return view('Eshopper.account', compact('add', 'userInfo', 'paginate'));
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
    public function chkUserPassword(Request $request)
    {
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = Users::where('id', $user_id)->first();
        if (Hash::check($current_password, $check_password->password)) {
            echo "true";
            die;

        } else {
            echo "false";
            die;

        }
    
    }
    public function updatePassword(Request $request)
    {
        $data = $request->all();
        $old_password = Users::where('id', Auth::User()->id)->first();
        $current_pwd = $data['current_pwd'];
        if (Hash::check($current_pwd, $old_password->password)) {
            $new_password = bcrypt($data['new_pwd']);
            Users::where('id', Auth::User()->id)->update(['password' => $new_password]);
            return redirect()->back()->with('flash_message_success', 'Password updated Successfuully');
        } 
        else {
            return redirect()->back()->with('flash_message_success', 'Current password is incorrect');
        }
    }
    public function addtocart(Request $request)
    {      
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
        $user_email=Auth::User()->email;
        
        $countProduct = Cart::where(['product_id' => $data['product_id'], 'user_email' => $user_email])->count();
        $product_details=Product::where('id',$data['product_id'])->first();
        if($data['quantity']>$product_details->quantity){
        return redirect()->back()->with('flash_message_error', 'Required quantity is not availabel');
        }
   
        else if ($countProduct > 0) {
            return redirect()->back()->with('flash_message_error', 'Product already exists in the cart
            ');
        } else {
            $getSku = Product::where('id', $data['product_id'])->first();
            Cart::insert(['product_id' => $data['product_id'], 'product_name' => $data['product_name'], 'product_code' => $getSku->sku, 'price' => $data['price'], 'quantity' => $data['quantity'], 'user_email' => $user_email]);
            
        }
        return redirect('cart')->with('flash_message_success', 'Product has been added to cart|');

    }
    public function addtowishlist(Request $request)
    {
       
        $data = $request->all();
        $user_email=Auth::User()->email;
        $user_id=Auth::User()->id;
      
       
        $countProduct = Wishlist::where(['product_id' => $data['product_id'], 'user_id' => $user_id])->count();
        $product_details=Product::where('id',$data['product_id'])->first();
        if($data['quantity']>$product_details->quantity){
        return redirect()->back()->with('flash_message_error', 'Required quantity is not availabel');
        }
   
        else if ($countProduct > 0) {
            return redirect()->back()->with('flash_message_error', 'Product already exists in the cart
            ');
        } 
         else {
            Wishlist::insert(['product_id' => $data['product_id'],'user_id'=>$user_id]);
        }
        return redirect('wishlist')->with('flash_message_success', 'Product has been added to wishlist|');

    }

    public function cart(Request $request)
    {    
        $userId = Auth::User()->id;
         if(Auth::check()){
           
        $user_email=Auth::User()->email;
        $userCart = Cart::where('user_email', $user_email)->get();


        }
      
        $coupon=Coupon::all();
        foreach ($userCart as $key => $product) {
            $productDetail = Product::where('id', $product->product_id)->first();
            $image = Product_images::where('product_id', $productDetail->id)->first();
            $userCart[$key]->image = $image->image_name;
        }
       
        return view('Eshopper.cart', compact('userCart','coupon'));
    }
    public function wishlist(Request $request)
    {  
        $user_id = Auth::User()->id;
         if(Auth::check()){
           
            $user_email=Auth::User()->email;
            $userWishlist = Wishlist::where('user_id', $user_id)->get();

            $productsDetails = Product::whereIn('id', $userWishlist->pluck('product_id'))->get();
        }
        
       
        foreach ($userWishlist as $key => $product) {
            $productDetail = Product::where('id', $product->product_id)->first();
            $image = Product_images::where('product_id', $productDetail->id)->first();
            $userWishlist[$key]->image = $image->image_name;
            $userWishlist[$key]->price = $productDetail->price;
            $userWishlist[$key]->product_code = $productDetail->sku;
            $userWishlist[$key]->name = $productDetail->name;
           
        }
       
        return view('Eshopper.wishlist', compact('userWishlist'));
    }
    public function deleteCartProduct($id)
    {   
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        Cart::where('id', $id)->delete();
        return redirect('cart')->with('flash_message_success', 'Product has been delete from cart|');
    }
    public function deleteWishlistProduct($id)
    {   
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        wishlist::where('id', $id)->delete();
        return redirect('wishlist')->with('flash_message_success', 'Product has been delete from wishlist|');
    }
    public function moveToCart($id)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        
        $user_email=Auth::User()->email;
        $user_id=Auth::User()->id;
        
        $getWishlistDetails = Wishlist::where('id', $id)->first();
        $getProduct = Product::where('id', $getWishlistDetails->product_id)->first();
        
        $countProduct = Cart::where(['product_id' => $getProduct->id, 'user_email' => $user_email])->count();
     
        if ($countProduct > 0) {
           return redirect()->back()->with('flash_message_error', 'Product already exists in the cart');
        } 
        else {
            Cart::insert(['product_id' => $getProduct->id, 'product_name' => $getProduct->name, 'product_code' => $getProduct->sku, 'price' => $getProduct->price, 'quantity' => 1, 'user_email' => $user_email]);
            wishlist::where('product_id',$getProduct->id)->delete();
        }
        
        return redirect('wishlist')->with('flash_message_success', 'Product has been moved to cart|');

    }
    public function updateCartQuantity($id, $quantity)
    {
        Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $getCartDetails = Cart::where('id', $id)->first();
        $getProduct = Product::where('sku', $getCartDetails->product_code)->first();
        $update_quantity = $getCartDetails->quantity + $quantity;
        if ($getProduct->quantity >= $update_quantity) {
            Cart::where('id', $id)->increment('quantity', $quantity);
            return redirect('cart')->with('flash_message_success', 'Product has been updated to cart|');
        } else {
            return redirect('cart')->with('flash_message_error', 'Requird Product is not available');
        }

    }
    public function applyCoupon(Request $request)
    {   Session::forget('CouponAmount');
        Session::forget('CouponCode');
        $data = $request->all();
        $userId = Auth::User()->id;
        $user_email= Auth::User()->email;
        $couponCount = Coupon::where('code', $data['coupon'])->count();
        if ($couponCount == 0) {
            return redirect()->back()->with('flash_message_error', 'Invalid coupon code');
        } else {
            $couponDetails = Coupon::where('code', $data['coupon'])->first();
            $couponUsedDetails = CouponUsed::where([
                ['userId', '=', $userId],
                ['couponcode', '=', $couponDetails->code],
            ])->first();

            if ($couponDetails->no_of_uses == 0) {
                return redirect()->back()->with('flash_message_error', 'Coupon is not Available');

            } else {
               
               
                $userCart = Cart::where('user_email', $user_email)->get();
                $total_amount = 0;
                foreach ($userCart as $item) {
                    $total_amount = $total_amount + ($item->price * $item->quantity);
                }
                
                if (empty($couponUsedDetails->id)) {

                    $available_coupon = $couponDetails->no_of_uses;
                    $couponAmount = $total_amount * ($couponDetails->percent_off / 100);
                    $remCoupon = $available_coupon - 1;
                    CouponUsed::insert(['userId' => $userId, 'couponcode' => $data['coupon'], 'remCoupon' => $remCoupon]);

                } else if ($couponUsedDetails->remCoupon == 0) {

                    return redirect()->back()->with('flash_message_error', 'All Coupons are Already used');

                } else {

                   
                    $available_coupon = $couponUsedDetails->remCoupon;
                    $couponAmount = $total_amount * ($couponDetails->percent_off / 100);
                    $remCoupon = $available_coupon - 1;
                    $couponUsedDetails->userId = $userId;
                    $couponUsedDetails->couponcode = $data['coupon'];
                    $couponUsedDetails->remCoupon = $remCoupon;
                    $couponUsedDetails->save();
                }
                Session::put('CouponAmount', $couponAmount);
                Session::put('Couponcode', $data['coupon']);
                
                return redirect()->back()->with('flash_message_success', 'Discount Coupon is applied successfully.You are availing discount');

            }
            

        }
    }
    public function contact(Request $request)
    {
        if($request->isMethod('post')){
            
            $request->validate([
                'name'=>'required|regex:/[A-Za-z\-\_]+/',
                'email'=>'required|email',
                'subject'=>'required',
                'message'=>'required',
                'contact'=>'required|numeric|regex:/\d{10}/',
            ]);
            $data=$request->all();
            
            $email="kumaripri6@gmail.com";
            $messageData=[
                'name'=>$data['name'],
                'email'=>$data['email'],
                'subject'=>$data['subject'],
                'comment'=>$data['message']
            ];
            Mail::send('emails.enquiry', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('New Enquiry');
               
    
            });
            Contact::insert(['name'=>$data['name'],'email'=>$data['email'],'contact_no'=>$data['contact'],'message'=>$data['message'],'created_by'=>Auth::User()->id,'note_admin'=>$data['note_admin']]);
            return redirect()->back()->with('flash_message_success', 'Thanks for your enquiry.We will get back to you soon');

        }
     return view('Eshopper.contact'); 
       
    }
    public function checkout(Request $request)
    {  
        
       $user_id=Auth::User()->id;
       $userAddress=Address::where('userId',$user_id)->first();
      
       $userDetails=Users::where('id',$user_id)->first();
       $countries=Country::all();
       $shippingCount=DeliveryAddresses::where('userId',$user_id)->count();
       $shippingDetails = array();

       if($shippingCount>0)
       {
           $shippingDetails=DeliveryAddresses::where('userId',$user_id)->first();
       }
       
       if($request->isMethod('post')){
           $data=$request->all();
           $request->validate([
            'billing_name'=>'required|regex:/[A-Za-z\-\_]+/',
            'billing_address'=>'required|',
            'billing_city'=>'required|regex:/[A-Za-z\-\_]+/',
            'billing_state'=>'required|regex:/[A-Za-z\-\_]+/',
            'billing_pincode'=>'required|numeric|regex:/\d{6}/',
            'billing_mobile'=>'required|numeric|regex:/\d{10}/',
            'billing_country'=>'required',
            'shipping_name'=>'required|regex:/[A-Za-z\-\_]+/',
            'shipping_address'=>'required|',
            'shipping_city'=>'required|regex:/[A-Za-z\-\_]+/',
            'shipping_state'=>'required|regex:/[A-Za-z\-\_]+/',
            'shipping_pincode'=>'required|numeric|regex:/\d{6}/',
            'shipping_mobile'=>'required|numeric|regex:/\d{10}/',
            'shipping_country'=>'required',

        ]);
        //    if(empty($data['billing_name']) || empty($data['billing_address']) || empty($data['billing_city']) ||empty($data['billing_pincode']) ||empty($data['billing_mobile']) ||
        //     empty($data['billing_state']) || empty($data['billing_country'])) {
        //     return redirect()->back()->with('flash_message_error',"Please fill all the fields of checkout");

        //    }
           $addressCount=Address::where('userId',$user_id)->count();
           if($addressCount==0){
            $billing=new Address();
            $billing->userId=$user_id;
           
            $billing->address=$data['billing_address'];
            $billing->city=$data['billing_city'];
            $billing->state=$data['billing_state'];
            $billing->pincode=$data['billing_pincode'];
            $billing->country=$data['billing_country'];
            $billing->mobile=$data['billing_mobile'];
            $billing->save();
           }
           else{
           Address::where('userId',$user_id)->update([
               'address'=>$data['billing_address'],'city'=>$data['billing_city'],'pincode'=>$data['billing_pincode'],'state'=>$data['billing_state'],'country'=>$data['billing_country'],'mobile'=>$data['billing_mobile'],
               ]);
               $userDetails->firstname=$data['billing_name'];
               $userDetails->save();
            }
               if($shippingCount>0){
                   DeliveryAddresses::where('userId',$user_id)->update([
                   'name'=>$data['shipping_name'], 'address'=>$data['shipping_address'],'city'=>$data['shipping_city'],'pincode'=>$data['shipping_pincode'],'state'=>$data['shipping_state'],'country'=>$data['shipping_country'],'mobile'=>$data['shipping_mobile']
                    ]);
               }
               else{
                   $shipping=new DeliveryAddresses();
                   $shipping->userId=$user_id;
                   $shipping->userEmail=$userDetails->email;
                   $shipping->name=$data['shipping_name'];
                   $shipping->address=$data['shipping_address'];
                   $shipping->city=$data['shipping_city'];
                   $shipping->state=$data['shipping_state'];
                   $shipping->pincode=$data['shipping_pincode'];
                   $shipping->country=$data['shipping_country'];
                   $shipping->mobile=$data['shipping_mobile'];
                   $shipping->save();
               }
               return redirect('/order-review');
           
       }
       return view('Eshopper.checkout',compact('userAddress','userDetails','countries','shippingDetails'));
    }
    public function orderReview()
    {
        $user_id=Auth::User()->id;
       
        $user_email=Auth::User()->email;
        $userAddress=Address::where('userId',$user_id)->first();
        
        $userDetails=Users::where('id',$user_id)->first();
        $shippingDetails=DeliveryAddresses::where('userId',$user_id)->first();
        $userCart = Cart::where('user_email', $user_email)->get();
       foreach ($userCart as $key => $product) {
           $productDetail = Product::where('id', $product->product_id)->first();
           $image = Product_images::where('product_id', $productDetail->id)->first();
           $userCart[$key]->image = $image->image_name;
       }
    
        return view('Eshopper.order_review',compact('userAddress','userDetails','shippingDetails','userCart'));
    }
    public function placeOrder(Request $request)
    {
        $data=$request->all();
       
        $user_id=Auth::User()->id;
        $user_email=Auth::User()->email;
        if(empty(Session::get('Couponcode'))){
            $coupon_id=NULL;
        }
            
        else{
            $couponcode=Session::get('Couponcode');
            $CouponDetails=Coupon::where('code',$couponcode)->first();
            $coupon_id=$CouponDetails->id;
        }
       
        $shippingDetails=DeliveryAddresses::where('userEmail',$user_email)->first();
        $billingDetails=Address::where('userId',$user_id)->first();
        $user_order=new UserOrder();
        $user_order->user_id=$user_id;
        if($data['payment_method']=="COD"){
        $user_order->shipping_method=$data['payment_method'];
        }
        else{
            $user_order->shipping_method="progress";
        }
        $user_order->transcation_id=mt_rand(4342,434346);
        $user_order->status="pending";
        $user_order->grand_total=$data['grand_total'];
        $user_order->coupon_id=$coupon_id;
        $user_order->billing_address=$billingDetails->address;
        $user_order->billing_city=$billingDetails->city;
        $user_order->billing_state=$billingDetails->state;
        $user_order->billing_country=$billingDetails->country;
        $user_order->billing_pincode=$billingDetails->pincode;
        $user_order->shipping_address=$shippingDetails->address;
        $user_order->shipping_city=$shippingDetails->city;
        $user_order->shipping_state=$shippingDetails->state;
        $user_order->shipping_country=$shippingDetails->country;
        $user_order->shipping_pincode=$shippingDetails->pincode;
        $user_order->save();
        $order_id=DB::getPdo()->lastInsertId();
        $cartProduct=Cart::where('user_email',$user_email)->get();
        foreach($cartProduct as $pro)
        {
            $orderDetails=new OrderDetails;
            $orderDetails->order_id=$order_id;
            $orderDetails->product_id=$pro->product_id;
            $orderDetails->quantity=$pro->quantity;
            $orderDetails->amount=$pro->price;
            $orderDetails->save();
        }
        Session::put('order_id',$order_id);
        Session::put('grand_total',$data['grand_total']);
        if($data['payment_method']=='COD'){
            $email=$user_email;
            $productDetails=UserOrder::with('orders')->where('id',$order_id)->first();
            $productDetails=json_decode(json_encode($productDetails),true);
            $user_addresss=Address::where('userId', $user_id)->first();
            $mytime =date("Y-m-d h:i:s a", time());
            
            $messageData=[
                'email'=>$user_email,
                'productDetails'=>$productDetails,
                'user_addresss'=>$user_addresss,
                'mytime'=>$mytime
               
            ];
          
            Mail::send('emails.order', $messageData,function ($message) use ($email) {
                $message->to($email)->subject('Order Details');
            });
            $email="kumaripri6@gmail.com";
            Mail::send('emails.order', $messageData,function ($message) use ($email) {
                $message->to($email)->subject('Order Details');
            });
            return redirect('thanks');
        }
        else{
            return redirect('/paywithpaypal');
        }
        
    }
    public function thanks(Request $request)
    {  
        Session::forget('Couponcode');
        $user_email=Auth::User()->email;
        $userCart = Cart::where('user_email', $user_email)->delete();
        return view("orders.thanks");
    }

    public function userOrders()
    {
        $user_id=Auth::User()->id;
        $orders=UserOrder::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->paginate(5);
       
        return view('orders.users_orders',compact('orders'));
    }

    public function userOrderDetails($order_id)
    {
        $user_id=Auth::User()->id;
        $orderDetails=UserOrder::with('orders')->where('id',$order_id)->first();
        return view('orders.user_order_details',compact('orderDetails'));

    }

    public function track()
    {
        
        return view('Eshopper.track');
    }

    public function trackOrder(Request $request)
    {
       $request->validate([
        'order_id'=>'required|numeric',
        'email'=>'required'
       ]);
       $user_email=Auth::User()->email;
       $user_id=Auth::User()->id;
       $data=$request->all();
       
       $order_id=$data['order_id'];
       $order_details=UserOrder::where('id',$order_id)->first();
       if(empty($order_details)){
          return redirect()->back()->with('flash_message_error','Invalid Order id');
        }
       else{
            $user_details=Users::where('id',$order_details->user_id)->first();
            if($user_details->email==$data['email']){
                return view('Eshopper.track_order',compact('order_details'));
            }
            else{
                return redirect()->back()->with('flash_message_error','Invalid Order id or email');
            }
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
