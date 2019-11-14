<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table='contact_us';
    protected $fillable=['name','email','contact_no','message','note_admin','created_by','modified_by'];
}
