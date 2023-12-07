<?php
namespace App\Http\Middleware;
use Closure;
class AuthenticateAdmin
{

    public function handle($request, Closure $next, $guard="admin")
    {

        if(!auth()->guard($guard)->check()) {
            return redirect(route('admin'));
        }
        return $next($request);
    }
}