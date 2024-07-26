<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 18:55:31
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 19:22:44
 * @FilePath: \app\Listeners\Phone\User\UserApplyRealAuthEvent\UpdateUserInfoListener.php
 */

namespace App\Listeners\Phone\User\UserApplyRealAuthEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;

use App\Exceptions\Phone\CommonException;

use App\Models\User\UserInfo;

class UpdateUserInfoListener
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
        $user = $event->user;
        $validated = $event->validated;
        $isTransation = $event->isTransation;

        $userInfo = UserInfo::where('user_id',$user->id)->first();

		if(!$userInfo)
		{
            if($isTransation)
            {
                DB::rollBack();
            }

			throw new CommonException('UserRealAuthApplyNoUserInfoError');
		}

		$userInfo->real_name = $validated['real_name'];
		$userInfo->id_number = $validated['id_number'];

		$userInfoResult = $userInfo->save();

		if(!$userInfoResult)
		{
			if($isTransation)
            {
                DB::rollBack();
            }

			throw new CommonException('UserRealAuthApplySaveUserInfoError');
		}

    }
}
