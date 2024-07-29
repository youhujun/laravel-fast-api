<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-29 14:47:48
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-29 15:08:52
 * @FilePath: \app\Listeners\Phone\User\Location\UserLocationLogEvent\AddUserLocationLogListener.php
 */

namespace App\Listeners\Phone\User\Location\UserLocationLogEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Exceptions\Phone\CommonException;

use App\Models\User\Log\UserLocationLog;

/**
 * @see \App\Events\Phone\User\Location\UserLocationLogEvent
 */
class AddUserLocationLogListener
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
		$address = $event->address;
        $isTransation = $event->isTransation;

		['latitude'=>$latitude,'longitude'=>$longitude] = $validated;

		$userLocationLog = new UserLocationLog;

		$userLocationLog->user_id = $user->id;
		$userLocationLog->latitude = $latitude;
		$userLocationLog->longitude = $longitude;
		$userLocationLog->created_at = time();
		$userLocationLog->created_time = time();
		$userLocationLog->address = $address;

		$result = $userLocationLog->save();

		if(!$result)
		{
            if($isTransation)
            {
                DB::rollBack();
            }

			throw new CommonException('AddUserLocationLogError');
		}
    }
}
