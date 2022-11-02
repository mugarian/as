<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if (!auth()->check() || auth()->user()->role != 'admin' ) {
            return response()->json(['message' => 'Forbidden. Only Admin can access!'], 403);
        }

        return $next($request);
    }
}
