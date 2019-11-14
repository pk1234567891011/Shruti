<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;
class UserOrder extends Model
{
    protected $table="user_order";
    protected $fillable=['user_id','shipping_method','AWB_NO','transaction_id','status','grand_total','shipping_charges','coupon_id','billing_address','billing_city','billing_state','billing_country','billing_pincode','shipping_address','shipping_city','shipping_state','shipping_country','shipping_pincode'
    ];
    public function orders(){
        return $this->hasMany('App\OrderDetails','order_id');
    }
    public static function getOrderDetails($order_id){
        $orderDetails=UserOrder::where('id',$order_id)->first();
        return $orderDetails;
    }
    public static function getCountryCode($country){
        $getCountryCode=Country::where('country_name',$country)->first();
        return $getCountryCode;
    }
}
