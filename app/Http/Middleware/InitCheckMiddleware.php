<?php

namespace App\Http\Middleware;

use App\Channel;
use Closure;
use Illuminate\Support\Facades\Auth;

class InitCheckMiddleware
{
    /**
     * Handle checking init_setup for registered users
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Check if user if Auth user
        if (Auth::user())
        {
            if(!Auth::user()->init_setup)
            {
                $channels = Channel::all();
                return view('init-check.displayname',compact('channels'));
            }
        }
        return $next($request);
    }
}
