<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guard = empty($guards) ? [null] : $guards;

        /*foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }*/
        // $user = User::where(['email' => "stepinhelper@gmail.com",'status' =>'Active'])->first();
        // Auth::login($user);
        if ($guard == "admin" && Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::AdminHOME);
        }
        if ($guard == "web" && Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
        }


        return $next($request);
    }
}
