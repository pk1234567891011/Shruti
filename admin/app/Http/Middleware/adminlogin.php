<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(Session::has('adminSession')))
        {
            return redirect('/mains');
        }
        return $next($request);
    }
}
