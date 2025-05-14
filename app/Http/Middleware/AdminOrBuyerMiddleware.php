<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrBuyerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'buyer'])) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Admin or Buyer access only.');
    }
}
