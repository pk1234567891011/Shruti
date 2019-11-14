<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddresses extends Model
{
    protected $table="delivery_addresses";
    protected $fillable=['userId','userEmail','name','address','city','state','country','pincode','mobile'];
}
