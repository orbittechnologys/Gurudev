<?php
namespace App\Http\Middleware;
use Closure;
class RevalidateBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache')
            ->header('Cache-Control','max-age=31536000') 
            ->header('Expires',date('Ymdhis'));
    }
}
