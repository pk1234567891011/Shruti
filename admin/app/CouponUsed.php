<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponUsed extends Model
{
   protected $table="_coupon_used";
   protected $fillable=['userId','couponId','remCoupon'];
}
