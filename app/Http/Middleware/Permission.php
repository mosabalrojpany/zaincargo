<?php

namespace App\Http\Middleware;

use Closure;

class Permission
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param   Array $permissions
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissions)
    {
        foreach ($permissions as $p) {
            if (auth()->user()->role->$p) {
                return $next($request);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'errors' => ['ليس لديك إذن للوصول']]
                , 403);
        }

        /* if users does not have permission to access to $permissions , so redirect him to error page 403 */
        abort(403, 'You do not have permission to access the requested resource');
    }

}
