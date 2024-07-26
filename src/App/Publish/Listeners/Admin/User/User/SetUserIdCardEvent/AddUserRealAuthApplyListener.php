<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-25 18:46:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 20:35:45
 * @FilePath: \app\Listeners\Admin\User\User\SetUserIdCardEvent\AddUserRealAuthApplyListener.php
 */

namespace App\Listeners\Admin\User\User\SetUserIdCardEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\User\User;

use App\Models\User\UserApplyRealAuth;

/**
 * @see \App\Events\Admin\User\User\SetUserIdCardEvent
 */
class AddUserRealAuthApplyListener
{
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

        //添加完用户银行卡以后,要添加用户实名认证申请
        //先查询该用户是否有申请中或者审核通过的情况
        $where = [];
        $where[] = ['user_id','=',$validated['user_id']];
        //正在申请中
        $where[] = ['status','=',10];

        $user = User::find($validated['user_id']);

        if(!$user)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $userApplyRealAuthNumber =  UserApplyRealAuth::where($where)->get()->count();

        if($userApplyRealAuthNumber)
        {
            throw new CommonException('ThisUserHasRealAuthError');
        }


        $userApplyRealAuth = new UserApplyRealAuth();

        $userApplyRealAuth->created_at = time();
        $userApplyRealAuth->created_time = time();
        $userApplyRealAuth->auth_apply_at = time();
        $userApplyRealAuth->auth_apply_time = time();
        $userApplyRealAuth->status = 10;
        $userApplyRealAuth->user_id = $validated['user_id'];

        $userApplyRealAuthResult = $userApplyRealAuth->save();

        if(!$userApplyRealAuthResult)
        {
            throw new CommonException('SetUserApplyRealAuthError');
        }
    }
}
