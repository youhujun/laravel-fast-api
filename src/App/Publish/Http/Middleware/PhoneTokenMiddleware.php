<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-28 08:54:16
 * @FilePath: \app\Http\Middleware\PhoneTokenMiddleware.php
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneTokenMiddleware
{

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Closure $next
     * @return void
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('phone_token')->user();

        if(empty($user))
        {
            return response()->json(code(\config('phone_code.PhoneTokenError')));
        }

        $request->attributes->add(['user'=>$user]);

        return $next($request);
    }
}
