<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrBuyerOrFarmerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'buyer', 'farmer'])) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Admin, Buyer, or Farmer access only.');
    }
}
