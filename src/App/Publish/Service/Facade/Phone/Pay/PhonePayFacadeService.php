<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 09:14:49
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 09:43:52
 * @FilePath: \app\Service\Facade\Phone\Pay\PhonePayFacadeService.php
 */

namespace App\Service\Facade\Phone\Pay;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Phone\CommonException;

use App\Facade\Phone\Pay\WechatPayFacade;

use App\Models\User\User;

/**
 * @see \App\Facade\Phone\Pay\PhonePayFacade
 */
class PhonePayFacadeService
{
   public function test()
   {
       echo "PhonePayFacadeService test";
   }

   /**
    * 测试支付示例
    *
    * @param  [type] $valdited
    */
   public function testPayOrder($validated,User $user)
   {
        $result = code(config('phone_code.PayOrderError'));

        if(!isset($validated['pay_type']) || !isset($validated['order_id']))
        {
            throw new CommonException('PayOrderParamsError');
        }

        //支付方式
        $pay_type = $validated['pay_type'];

        $order_id = $validated['order_id'];

        //微信的js支付
        if($pay_type == 10)
        {
           $result =  WechatPayFacade::payOrderByJs($order_id,$user);
        }

        return $result;
   }
}
