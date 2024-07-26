<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-06 19:38:19
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Http\Middleware\AdminTokenMiddleware.php
 */


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminTokenMiddleware
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

        $admin = Auth::guard('admin_token')->user();

        if(empty($admin))
        {
            return response()->json(code(\config('admin_code.AdminTokenError')));
        }

        $request->attributes->add(['admin'=>$admin]);

        return $next($request);
    }
}
