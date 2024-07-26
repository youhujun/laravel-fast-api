<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 12:50:24
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 13:59:03
 * @FilePath: \app\Service\Facade\Phone\Notify\PhonePayNotifyFacadeService.php
 */

namespace App\Service\Facade\Phone\Notify;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Facade\Public\Wechat\Pay\WechatJsPayDecryptFacade;

/**
 * @see \App\Facade\Phone\Notify\PhonePayNotifyFacade
 */
class PhonePayNotifyFacadeService
{
   public function test()
   {
       echo "PhonePayNotifyFacadeService test";
   }

   /**
    *
    *
    * @param  [type] $notifyData
    */
   public function wechatJsPayNotify($notifyData)
   {
        //p($notifyData);die;
        $result = code(config('phone_code.WechatJsPayNotifyError'));

        Log::debug(['$notifyData:微信Js支付回调数据' => $notifyData]);

        $inBodyResourceArray = WechatJsPayDecryptFacade::decryptData($notifyData);

        Log::debug(['$inBodyResourceArray:解密数据' => $inBodyResourceArray]);

        /**
         *
         *  array (
            'mchid' => '1634317589',
            'appid' => 'wx09f89f9e9d5f72ba',
            'out_trade_no' => '2024071255994949',
            'transaction_id' => '4200002301202407125009374824',
            'trade_type' => 'JSAPI',
            'trade_state' => 'SUCCESS',
            'trade_state_desc' => '支付成功',
            'bank_type' => 'OTHERS',
            'attach' => '{"order":{"order_id":1,"order_sn":"2024071255994949"},"goods":[1,2,3],"user":14}',
            'success_time' => '2024-07-12T16:55:58+08:00',
            'payer' =>
            array (
            'openid' => 'oYFqa5nW_bn2icDWNBi4xEXpRf5E',
            ),
            'amount' =>
            array (
            'total' => 10,
            'payer_total' => 10,
            'currency' => 'CNY',
            'payer_currency' => 'CNY',
            ),
        ),
        )
         */

        ['trade_type'=>$trade_type,'trade_state'=>$trade_state,'bank_type' => $bank_type,'attach'=>$attach] = $inBodyResourceArray;

        $attachArray = \json_decode($attach,true);

        ['order'=>$orderArray,'goods'=>$goodsIdArray,'user'=>$user_id] = $attachArray;

        ['order_id'=>$order_id,'order_sn'=>$order_sn] = $orderArray;

        Log::debug(['$attachArray'=>$attachArray]);

        /**
         * array (
            'order' =>
            array (
            'order_id' => 1,
            'order_sn' => '2024071255994949',
            ),
            'goods' =>
            array (
            0 => 1,
            1 => 2,
            2 => 3,
            ),
            'user' => 14,
        ),
         */

   }
}
