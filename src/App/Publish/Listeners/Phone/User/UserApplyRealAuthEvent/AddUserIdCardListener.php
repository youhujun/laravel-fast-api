<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 18:55:56
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-15 08:04:58
 * @FilePath: \app\Listeners\Phone\User\UserApplyRealAuthEvent\AddUserIdCardListener.php
 */

namespace App\Listeners\Phone\User\UserApplyRealAuthEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;

use App\Exceptions\Phone\CommonException;

use App\Models\User\User;

use App\Models\User\UserIdCard;

class AddUserIdCardListener
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

        $userIdCard = UserIdCard::where('user_id',$user->id)->first();

		if(!$userIdCard)
		{
			$userIdCard = new UserIdCard;
		}

		$userIdCard->created_at = time();
		$userIdCard->created_time = time();
		$userIdCard->sort = 100;
        $userIdCard->user_id = $user->id;
		$userIdCard->id_card_front_id = $validated['id_card_front_id'];
		$userIdCard->id_card_back_id = $validated['id_card_back_id'];

		$userIdCardResult = $userIdCard->save();

		if(!$userIdCardResult)
		{
            if($isTransation)
            {
                DB::rollBack();
            }

			throw new CommonException('UserRealAuthApplySaveUserIdCardError');
		}

    }
}
