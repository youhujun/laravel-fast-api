<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 08:18:45
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 11:19:49
 * @FilePath: \app\Service\Facade\Phone\Pay\WechatPayFacadeService.php
 */

namespace App\Service\Facade\Phone\Pay;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Phone\CommonException;
use App\Events\Phone\CommonEvent;

use App\Models\User\UserWechat;

use App\Facade\Public\Wechat\Pay\WechatJsPayFacade;

/**
 * @see \App\Facade\Phone\Pay\WechatPayFacade
 */
class WechatPayFacadeService
{
   public function test()
   {
       echo "WechatPayFacadeService test";
   }


   /**
    * h5 微信公众号支付
    *
    * @param [type] $orderData
    * @return void
    */
   public function payOrderByJs($order_id,$user)
   {
        $result = code(config('phone_code.WechatPayOrderByJsError'));

        //openid
        $openid = '';

        $where = [];
        $where[] = ['user_id','=',$user->id];
        //openid
        $userWechat = UserWechat::where($where)->first();

        if($userWechat )
        {
            $openid =  $userWechat->openid;
        }

        if(!$openid)
        {
            throw new CommonException('WechatPayOrderByJsNoUserOpenidError');
        }

        //订单id
        $order_id = 1;
        //订单编号
        $order_sn = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);

        //支付金额
        $order_real_pay_amount = 0.1;
        //订单支付失效时间
        $orderPayExpireTime = time() + 30 * 60;
        //订单描述
        $orderDescription = '测试订单';

        //产品id数组
        $goodsIdArray = [1,2,3];

        //用户id
        $user_id = $user->id;

        //备注
        $bakData = [
            'order'=>
            [
                'order_id'=>$order_id,
                'order_sn'=>$order_sn,
            ],
            'goods'=>$goodsIdArray,
            'user'=>$user_id
        ];

        //==========================提交数据===============================

        $orderData = [];

        //订单编号
        $orderData['out_trade_no'] = $order_sn;
        //支付金额
        $orderData['amount']['total'] = (int)bcmul($order_real_pay_amount,100);
        //支付方式
        $orderData['amount']['currency'] ='CNY';
        //支付失效时间:
        $orderData['time_expire'] = date('Y-m-d\TH:i:sP',$orderPayExpireTime);
        //订单描述
        $orderData['description'] =$orderDescription;
        //openid
        $orderData['payer']['openid'] =$openid;
        //备注信息
        $orderData['attach'] = json_encode($bakData);

        /**
         * Array
            (
                [out_trade_no] => 2024071253485798
                [amount] => Array
                    (
                        [total] => 10
                        [currency] => CNY
                    )

                [time_expire] => 2024-07-12T10:15:09+08:00
                [description] => 测试订单
                [payer] => Array
                    (
                        [openid] => oYFqa5nW_bn2icDWNBi4xEXpRf5E
                    )

                [attach] => {"order":{"order_id":1,"order_sn":"2024071253485798"},"goods":[1,2,3],"user":14}
            )
         */

        //p($orderData);die;

        $resultArray =  WechatJsPayFacade::prePayOrder($orderData);

        Log::debug(['$resultArray'=>$resultArray]);

        //事件处理根据自身情况去定义

        $result = code(['code'=> 0,'msg'=>'微信支付下单成功!'],['data'=>$resultArray]);

        return $result;
   }
}
