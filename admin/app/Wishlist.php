<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table='user_wish_list';
    protected $fillable=['user_id','product_id'];
}
