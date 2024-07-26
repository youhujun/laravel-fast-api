<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-07 21:21:20
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-27 16:14:54
 * @FilePath: \app\Listeners\ReplaceListener.php
 */

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
// use App\Exceptions\Admin\CommonException;
// use App\Exceptions\Phone\CommonException;

class ReplaceListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event): void
    {
        $admin = $event->admin;
        $user = $event->user;
        $validated = $event->validated;
        $isTransation = $event->isTransation;

		if(!$result)
		{
            if($isTransation)
            {
                DB::rollBack();
            }

			throw new CommonException('');
		}
    }
}
