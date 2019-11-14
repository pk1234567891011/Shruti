<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cms extends Model
{
    protected $table='cms';
    protected $fillable=['title','url','description','status'];
}
