<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 15:30:00
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 13:59:51
 * @FilePath: \app\Jobs\Admin\Login\AdminLogoutJob.php
 */

namespace App\Jobs\Admin\Login;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;
use Illuminate\Support\Facades\Log;

use App\Models\Admin\Admin;

use App\Jobs\Middleware\RateLimited;

use Illuminate\Support\Facades\Redis;

class AdminLogoutJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin;
    /**
     * 任务尝试次数
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 3;

    /**
     * 任务失败前允许的最大异常数
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * 如果任务的模型不再存在，则删除该任务
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;


    /**
     * Create a new job instance.
     */
    public function __construct(Admin $admin)
    {
         $this->admin = $admin->withoutRelations();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        //执行逻辑
        $admin = $this->admin;
         try
        {

            //如果有说明没有执行退出
            if ($admin->remember_token)
            {
                $result = 0;

                $this->clearAdminCache($admin, $admin->remember_token);

                $admin->remember_token = null;

                $result = $admin->save();

                if($result)
                {
                    Log::debug(['AdminLogoutJobSuccess'=>'自动退出成功']);
                }
                else
                {
                    Log::debug(['AdminLogoutJobError'=>code(config('admin_code.AdminLogoutJobError'))]);
                }
            }

        }
        catch (\Throwable $th)
        {
           // em($th, true);
           Log::debug(['error'=>$th]);
        }
    }

    public function middleware()
    {
         return [new RateLimited];
    }

    /**
     * 清除管理员缓存
     *
     * @param  Admin  $admin
     * @param  [String] $token
     */
    private function clearAdminCache(Admin $admin, $token)
    {
        Redis::del("admin_token:{$token}");
        Redis::hdel("admin:admin",$admin->id);
        Redis::hdel("admin_info:admin_info",$admin->id);
    }
}
