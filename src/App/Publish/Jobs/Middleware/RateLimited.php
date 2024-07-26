<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 16:00:47
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-05 16:01:11
 * @FilePath: d:\wwwroot\Working\PHP\Laravel\api.laravel.com\app\Jobs\Middleware\RateLimited.php
 */


namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;

class RateLimited
{
    /**
     * 让队列任务慢慢执行
     *
     * @param  mixed  $job
     * @param  callable  $next
     * @return mixed
     */
    public function handle($job, $next)
    {
         Redis::throttle('key')
                ->block(0)->allow(1)->every(5)
                ->then(function () use ($job, $next) {
                    // 获取锁 ...

                    $next($job);
                }, function () use ($job) {
                    // 无法获取锁 ...

                    $job->release(5);
                });
    }
}
