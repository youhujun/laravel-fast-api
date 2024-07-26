<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 17:40:24
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-15 08:03:42
 * @FilePath: \app\Service\Facade\Phone\User\User\PhoneUserFacadeService.php
 */

namespace App\Service\Facade\Phone\User\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Phone\CommonException;
use App\Events\Phone\CommonEvent;
use App\Events\Phone\User\UserApplyRealAuthEvent;

use App\Models\User\UserApplyRealAuth;

class PhoneUserFacadeService
{
   public function test()
   {
       echo "PhoneUserFacadeService test";
   }

    /**
    * 用户申请实名认证
    *
    * @param [type] $validated
    * @param [type] $user
    * @return void
    */
   public function realAuthApply($validated,$user)
   {
		$result = code(config('phone_code.UserRealAuthApplyError'));

        //先检测用户是否已经认证
        if($user->real_auth_status == 20)
        {
            throw new CommonException('UserHasRealAuthApplyError');
        }

		DB::beginTransaction();

        $userApplayRealAuth = new UserApplyRealAuth;

		$userApplayRealAuth->user_id = $user->id;
		$userApplayRealAuth->sort = 100;
		$userApplayRealAuth->created_at = time();
		$userApplayRealAuth->created_time = time();
        //状态 申请中
		$userApplayRealAuth->status = 10;
		$userApplayRealAuth->auth_apply_at = time();
		$userApplayRealAuth->auth_apply_time = time();

		$userApplayRealAuthResult = $userApplayRealAuth->save();

		if(!$userApplayRealAuthResult)
		{
			DB::rollBack();
			throw new CommonException('UserRealAuthApplyError');
		}

        UserApplyRealAuthEvent::dispatch($user,$validated,1);

        CommonEvent::dispatch($user,$validated,'UserRealAuthApply',1);

		DB::commit();

		$result = code(['code'=> 0,'msg'=>'用户申请实名认证成功!']);

		return $result;

   }
}
