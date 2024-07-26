<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-26 14:53:58
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 19:50:09
 * @FilePath: \app\Listeners\Admin\User\User\SetUserAccountEvent\AddUserAccountLogListener.php
 */

namespace App\Listeners\Admin\User\User\SetUserAccountEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\Log\UserBalanceLog;
use App\Models\User\Log\UserCoinLog;
use App\Models\User\Log\UserScoreLog;

/**
 * @see \App\Events\Admin\User\User\SetUserAccountEvent
 */
class AddUserAccountLogListener
{
     protected $model = [
       10 => UserBalanceLog::class,
       20 => UserCoinLog::class,
       30 => UserScoreLog::class,
   ];

   protected $field = [
       10 => 'balance',
       20 => 'coin',
       30 => 'score'
   ];

   protected $remark_info = [
       10 => [
            10 => '后台充值余额',
            20 => '后台充值系统币',
            30 => '后台增加积分'
       ],
       20 => [
            10 => '后台扣除余额',
            20 => '后台扣除系统币',
            30 => '后台扣除积分'
       ]
    ];
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $admin = $event->admin;
        $validated = $event->validated;
        $isTransation = $event->isTransation;

        $amountLog =  new $this->model[$validated['account_type']];

        $amountLog->created_at = time();
        $amountLog->created_time = time();
        $amountLog->sort = 100;
        $amountLog->type = $validated['action_type'];
        $amountLog->user_id = $validated['user_id'];

        $amountLog->setAttribute($this->field[$validated['account_type']],$validated['amount']);

        $amountLog->remark_info = $this->remark_info[$validated['action_type']][$validated['account_type']];

        $amountLogResult = $amountLog -> save();

        if(!$amountLogResult)
        {
            if($isTransation)
            {
                DB::rollBack();
            }

            throw new  CommonException('SetUserAccountLogError');
        }
    }
}
