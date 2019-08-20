<?php

namespace App\Http\Middleware;

use Closure;

class Confession
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
            header('location:log');
        }
        return $next($request);
    }
}
