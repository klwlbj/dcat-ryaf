<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('/web/login'); // 如果用户未登录，则重定向到登录页面
        }

        return $next($request);
    }
}
