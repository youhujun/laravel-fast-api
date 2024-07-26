<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-10-14 09:44:09
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 16:54:02
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TimeVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        //p('here');die;
        $requestType =  $request->header('type');

        $requesetTime = \bcdiv( $request->header('time'),1000);

        if(isset( $requestType ) && !empty( $requestType) && isset( $requesetTime) && $requesetTime > 0)
        {

            if($requestType == 'picture')
            {
                $serverTime = time();

                $interval = \bcsub($serverTime,$requesetTime);

                //如果超过3秒就认为 请求超时
                if($interval > 3000)
                {
                    return response()->json(code(\config('common_code.TimeError')));
                }
            }
            else
            {
                $serverTime = time();
                /* p('请求时间');
                p($requesetTime);
                p('服务器时间');
                p($serverTime);die; */

                $interval = \bcsub($serverTime,$requesetTime);


                //如果超过1秒就认为 请求超时
                if($interval > 1000)
                {
                    return response()->json(code(\config('common_code.TimeError')));
                }
            }
        }


        return $next($request);
    }
}
