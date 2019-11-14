<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $table="order_details";
    protected $fillable=['order_id','product_id','quantity','amount'];
    public function order()
    {
        return $this->belongsTo('App\UserOrder');
    }
}
