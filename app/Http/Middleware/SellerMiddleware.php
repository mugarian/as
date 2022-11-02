<?php

namespace App\Http\Middleware;

use Closure;

class SellerMiddleware
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
        if (!auth()->check() || auth()->user()->role != 'seller' ) {
            return response()->json(['message' => 'Forbidden. Only Seller can access!'], 403);
        }

        return $next($request);
    }
}
