<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;
use Session;

class isDPScriber
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //return $next($request);
        if (Auth::user() &&  Auth::user()->isDPScriber()) {
            return $next($request);
       }
       Session::flash('error', 'You have not DP Scriber access');
       return redirect('home')->with('error','You have not DP Scriber access');
    }
}
