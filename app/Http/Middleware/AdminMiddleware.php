<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if(Auth::user()->usertype == 'admin')
        {
            return $next($request);
        }
        else{
                return redirect('/dashboard')->with('status','You are Not Allowed To Access the  Admin Dashboard');
        }
     
    }
    }
}
