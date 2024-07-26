<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-03 09:46:04
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-03 14:46:30
 * @FilePath: \app\Service\Facade\Phone\User\PhoneUserSourceFacadeService.php
 */

namespace App\Service\Facade\Phone\User;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Models\User\User;

/**
 * @see \App\Facade\Phone\User\PhoneUserSourceFacade
 */
class PhoneUserSourceFacadeService
{
   public function test()
   {
       echo "PhoneUserSourceFacadeService test";
   }

   protected $userUnionProperty = ['first_id','second_id'];

   /**
    * 获取需要添加用户的UserSourceUnion的id数组
    *
    * @param  User    $user
    * @param  integer $number
    */
   public function getInsertUserSourceUnionId(User $user,$number = 2)
   {
       $userSourceUnionIdArray = [];

       $sourceUser = null;

       $userSourceId = 0;

       for ($i=0; $i <$number ; $i++)
       {
            if($i === 0)
            {
                $sourceUser = $user;
            }
            else
            {
                if($userSourceId)
                {
                    $sourceUser = User::where('id',$userSourceId)->where('switch',1)->first();
                }

            }

            if($sourceUser)
            {
                $userSourceId = $sourceUser->source_id;
            }
            else
            {
                $userSourceId = 0;
            }

            $userSourceUnionIdArray[] = $userSourceId;

       }

       return $userSourceUnionIdArray;
   }

   /**
    * 获取需要添加的关联数据
    *
    * @param  User    $user
    * @param  integer $number
    */
   public function getInsertUserSourceUnionData(User $user,$number = 2)
   {
       $userSourceUnionIdArray =  $this-> getInsertUserSourceUnionId($user,$number);

       $UserSourceUnionData = [];

       foreach($userSourceUnionIdArray as $key => $value)
       {
            $UserSourceUnionData[$this->userUnionProperty[$key]] = $value;
       }

       return $UserSourceUnionData;
   }
}
