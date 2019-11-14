<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::view('admin/admin_template','admin.admin_template');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('index', function()
{
    return view('index');
});
Auth::routes();
Route::view('mains','login');

//facebook
Route::get('login/facebook', 'HomesController@redirectToProvider');
Route::get('login/facebook/callback', 'HomesController@handleProviderCallback');
//google
Route::get('/redirect', 'HomesController@redirect');
Route::get('/callback', 'HomesController@callback');
Route::post('/mains/checklogin', 'MainController@checklogin');
Route::get('mains/successlogin', 'MainController@successlogin');
Route::get('slider','HomesController@slider');
Route::group(['middleware'=>['adminlogin']],function(){

    Route::resource('/cms','CMSController');
    Route::resource('order','OrdersController');
    Route::resource('contact','ContactController');
    Route::get('customer','AdminOrderController@customer');
    Route::get('orderdetails','AdminOrderController@orderdetails');
    Route::get('userOrder','AdminOrderController@userOrder');
    Route::resource('users','UsersController');
    Route::resource('roles','RolesController');

    Route::resource('banner','BannerController');
    Route::resource('configuration','ConfigurationController');
    Route::resource('category','CategoryController');
    Route::resource('product','ProductController');
    Route::resource('product_attributes','ProductAttributeController');
    Route::get('myform/ajax/{id}',array('as'=>'myform.ajax','uses'=>'ProductController@myformAjax'));
    Route::resource('coupon','CouponController');
    
});

Route::match(['GET','POST'],'trial','NewsletterController@news');
Route::get('usersregistered', 'ChartController@index');
Route::get('SalesReport', 'ChartController@sales');
Route::get('CouponUsed', 'ChartController@couponused');
Route::get('logout', 'MainController@logout');
//Route::resource('login','HomesController');
Route::get('/login', 'HomeController@login')->name('login');
Route::match(['GET','POST'],'/login-register','HomesController@register');

Route::post('/login-register/checklogin', 'HomesController@checkslogin');
 Route::get('login-register/successlogin', 'HomesController@successlogins');
Route::get('logouts', 'HomesController@logouts');
Route::get('/products/{url}','HomesController@products');
Route::match(['GET','POST'],'forgot-password','HomesController@forgotPassword');

Route::group(['middleware'=>['frontlogin']],function(){
    Route::resource('homes','HomesController');
    Route::match(['GET','POST'],'account','HomesController@account');
    Route::post('/check-user-pwd','HomesController@chkUserPassword');
    Route::get('prod/{id}','HomesController@prod');
    //add to cart
    Route::match(['GET','POST'],'add-cart','HomesController@addtocart');
    Route::match(['get', 'post'], '/cart','HomesController@cart');
    Route::get('/cart/delete-product/{id}','HomesController@deleteCartProduct');
    Route::get('/cart/update-quantity/{id}/{quantity}','HomesController@updateCartQuantity');
    Route::post('/cart/apply-coupon','HomesController@applyCoupon');
    Route::match(['GET','POST'],'/page/contact','HomesController@contact');
    Route::match(['get','post'],'checkout','HomesController@checkout');
    Route::match(['get','post'],'/order-review','HomesController@orderReview');
    Route::match(['get','post'],'/place-order','HomesController@placeOrder');
    Route::get('/thanks','HomesController@thanks');
    Route::get('/orders','HomesController@userOrders');
    Route::get('/orders/{id}','HomesController@userOrderDetails');
    Route::match(['GET','POST'],'add-wishlist','HomesController@addtowishlist');
    Route::match(['get', 'post'], '/wishlist','HomesController@wishlist');
    Route::get('/wishlist/delete-product/{id}','HomesController@deleteWishlistProduct');
    Route::get('/wishlist/update-quantity/{id}/{quantity}','HomesController@updateWishlistQuantity');
    Route::match(['GET','POST'],'/wishlist/move-product/{id}','HomesController@moveToCart');
    Route::match(['GET','POST'],'track','HomesController@track');
    Route::match(['GET','POST'],'track_details','HomesController@trackOrder');
    Route::post('/update-user-pwd','HomesController@updatePassword');
    Route::resource('address','AddressController');
    
    Route::match(['get','post'],'/page/{url}','CMSController@cmsPage');
    Route::view('/paywithpaypal', 'paywithpaypal');
    Route::post('/paywithpaypal', 'PaymentController@createPayment')->name('create-payment');
    Route::get('/confirm', 'PaymentController@confirmPayment')->name('confirm-payment');
    // Route::get('paywithpaypal', array('as' => 'addmoney.paywithpaypal','uses' => 'AddMoneyController@payWithPaypal',));

    // Route::post('paypal', array('as' => 'addmoney.paypal','uses' => 'AddMoneyController@postPaymentWithpaypal',));
    
    // Route::get('paypal', array('as' => 'payment.status','uses' => 'AddMoneyController@getPaymentStatus',)); 
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//backend search
Route::get('/usersearch','UsersController@search');
Route::get('/bannersearch','BannerController@search');
Route::get('/categorysearch','CategoryController@search');
Route::get('/productsearch','ProductController@search');
Route::get('/attributesearch','ProductAttributeController@search');
Route::get('/couponsearch','CouponController@search');
Route::get('/tracksearch','OrdersController@search');
Route::get('/contactsearch','ContactController@search');
Route::get('/cmssearch','CMSController@search');
Route::get('/customersearch','AdminOrderController@searchCustomer');
Route::get('/orderdetailssearch','AdminOrderController@searchorderdetails');
Route::get('/userordersearch','AdminOrderController@searchuserorder');
//frontend search
Route::get('/allsearch','HomesController@allsearch');

