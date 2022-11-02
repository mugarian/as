<?php

namespace App\Http\Middleware;

use Closure;

class BuyerMiddleware
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
        if (!auth()->check() || auth()->user()->role != 'buyer' ) {
            return response()->json(['message' => 'Forbidden. Only Buyer can access!'], 403);
        }

        return $next($request);
    }
}
