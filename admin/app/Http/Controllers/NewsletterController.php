<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NewsletterSubscriber;
use Maatwebsite\Excel\Facades\Excel;
use Newsletter;
class NewsletterController extends Controller
{
   
    public function news(Request $request)
    {
            
        if ( ! Newsletter::isSubscribed($request->user_email) ) {
            Newsletter::subscribe($request->user_email);
            return redirect()->back()->with('flash_message_success','Thanks for subscribing');
        }
        else{
            return redirect()->back()->with('flash_message_error','Already subscribed');

        }
    }
   
}
