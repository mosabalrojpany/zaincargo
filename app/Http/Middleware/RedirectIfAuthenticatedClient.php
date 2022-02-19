<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfAuthenticatedClient
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
        if (authClient()->check()) {
            return redirect('/client/index');
        }

        return $next($request);
    }
}
