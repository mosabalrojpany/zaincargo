<?php

namespace App\Http\Middleware;

use App\Http\Helper\ClientSession;
use Closure;

class LastAccessClient
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
        /* Update last access for current session for client */
        ClientSession::update();

        return $next($request);
    }
}
