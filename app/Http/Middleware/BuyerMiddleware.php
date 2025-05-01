<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BuyerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            if ($request->inertia()) {
                return inertia()->location(route('login'));
            }
            return redirect('/login')->with('error', 'Please log in first.');
        }
    
        if (auth()->user()->role !== 'buyer') {
            if ($request->inertia()) {
                return inertia()->location('/');
            }
            return redirect('/')->with('error', 'Buyer access only.');
        }
    
        return $next($request);
    }
}
