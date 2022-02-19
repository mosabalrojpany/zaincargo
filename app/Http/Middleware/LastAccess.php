<?php

namespace App\Http\Middleware;

use App\Http\Helper\UserSession;
use Closure;


class LastAccess
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
        /* Update last access for current session for user */
        UserSession::update();

        return $next($request);
    }
}
