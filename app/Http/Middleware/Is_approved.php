<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Is_approved
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
        if (auth()->user()->approved == true) {
            return $next($request);
        }
        return redirect('/')->with('error', 'You are not approved, Contact one of the admins for approval');
    }
}
