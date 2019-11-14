<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $table='newsletter_subscriber';
    protected $fillable=['email','status'];
}
