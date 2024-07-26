<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-01 20:58:02
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-03 15:23:02
 * @FilePath: \app\Listeners\Phone\User\UserRegisterEvent\AddUserSourceListener.php
 */

namespace App\Listeners\Phone\User\UserRegisterEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Phone\CommonException;

use App\Models\User\Union\UserSourceUnion;
use App\Models\User\User;

use App\Facade\Phone\User\PhoneUserSourceFacade;

class AddUserSourceListener
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

        //p($validated);die;

        //是否推荐
        $isToSource = 0;
        $where = [];

         //查找上级用户的id
        if(isset($validated['inviteId']) && !empty($validated['inviteId']))
        {
            $isToSource = 1;
            $where[] = ['id','=',$validated['inviteId']];
        }

        if(isset($validated['inviteCode']) && !empty($validated['inviteCode']))
        {
            $isToSource = 1;
            $where[] = ['invite_code','=',$validated['inviteCode']];
        }

        if($isToSource)
        {
             $sourceUser = User::where($where)->first();

            if(!$sourceUser)
            {
                if($isTransation)
                {
                    DB::rollBack();
                }

                throw new CommonException('ThisDataNotExistsError');
            }

            $user->source_id = $sourceUser->id;

            //保存用户上级
            $userResult = $user->save();

            if(!$userResult)
            {
                if($isTransation)
                {
                    DB::rollBack();
                }

                throw new CommonException('SaveUserSourceError');
            }

            $userSourceUnionData = PhoneUserSourceFacade::getInsertUserSourceUnionData($user);

            $userSourceUnionData['user_id'] = $user->id;
            $userSourceUnionData['created_at'] = date('Y-m-d H:i:s',time());
            $userSourceUnionData['created_time'] = time();


            $serSourceUnionResult =  UserSourceUnion::insert($userSourceUnionData);

            if(!$serSourceUnionResult)
            {
                if($isTransation)
                {
                    DB::rollBack();
                }

                throw new CommonException('AddUserSourceUnionError');
            }
        }
    }
}
