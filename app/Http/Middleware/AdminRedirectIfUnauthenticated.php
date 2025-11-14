<?php

namespace App\Http\Middleware;

use Closure;

class AdminRedirectIfUnauthenticated
{
    public function handle($request, Closure $next)
    {
        if (!auth()->guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
