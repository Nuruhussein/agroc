<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOrFarmerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && in_array($user->role, ['admin', 'farmer'])) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Only admins or farmers can access this page.');
    }
}
