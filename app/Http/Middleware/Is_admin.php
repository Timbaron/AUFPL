<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Is_admin
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
        if(auth()->user()->is_admin == true){
            return $next($request);
        }
        return redirect()->back()->with('error', 'You are not authorized to access this page');
    }
}
