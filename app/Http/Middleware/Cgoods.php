<?php

namespace App\Http\Middleware;

use Closure;

class Cgoods
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
        $time = time();
        $data = date('Y-m-d H:i:s', $time);
        $time1 = strtotime("09:00:00");
        $time2 = strtotime("15:00:00");
        if ($time >= $time1 && $time <= $time2) {

        }else{
            echo '当前时间不可以修改';die;
//            return redirect('goods/index');
        }
        return $next($request);
    }
}
