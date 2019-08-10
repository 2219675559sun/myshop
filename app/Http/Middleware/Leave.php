<?php

namespace App\Http\Middleware;

use Closure;

class Leave
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
        if(empty(session('name'))){
            return redirect('leave/log');
        }
        return $next($request);
    }
}
