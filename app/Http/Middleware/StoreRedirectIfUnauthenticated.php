<?php

namespace App\Http\Middleware;

use Closure;

class StoreRedirectIfUnauthenticated
{
    public function handle($request, Closure $next)
    {
        if (!auth()->guard('store')->check()) {
            return redirect()->route('store.login');
        }

        return $next($request);
    }
}
