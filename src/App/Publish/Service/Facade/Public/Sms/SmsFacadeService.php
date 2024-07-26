<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-28 18:18:00
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-03 15:11:37
 * @FilePath: \app\Service\Facade\Public\Sms\SmsFacadeService.php
 */

namespace App\Service\Facade\Public\Sms;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use App\Exceptions\Phone\CommonException;
use App\Events\Phone\CommonEvent;

use App\Facade\Public\Sms\TencentSmsFacade;


/**
 * @see \App\Facade\Public\Sms\SmsFacade
 */
class SmsFacadeService
{
   public function test()
   {
       echo "SmsFacadeService test";
   }

    protected $server = ['tencent','alibaba'];

     /**
    * 生成验证码
    *
    * @return void
    */
   protected function initNumberCode()
   {
       $code = '';

       for ($i=0; $i < 4 ; $i++)
       {
            $code .= \mt_rand(0,9);
       }

       return $code;
   }

   /**
    * 发送验证码
    *
    * @param [type] $phone 手机好
    * @param array $smsParam
    * @return void
    */
   public function sendVerifyCode($phone)
   {
        $defaultServer = Cache::store('redis')->get('sms');

        if(!$defaultServer)
        {
            throw new CommonException('SmsInitError');
        }

        $code = $this->initNumberCode();

        $redisResult = Redis::setex("sms:{$phone}",60*10, $code);

        if(!$redisResult)
        {
            throw new CommonException('SmsCodeSaveError');
        }

        $sendResult = 0;

        //腾讯云发送短信验证码
        if($defaultServer === $this->server[0])
        {

            $templateId = trim(Cache::store('redis')->get("tencent.sms.templateId.userLogin"));

            if(!$templateId)
            {
                throw new CommonException('TencentSmsTemplateIdError');
            }

            //模版id
            // [tencent.sms.templateId.userRegist] => 1882890
            // [tencent.sms.templateId.userLogin] => 1882891
            $smsParam['templateId'] = $templateId;
            //短信内容
            $smsParam['smsContent'] = [];
            $smsParam['smsContent'][] = $code;
            //手机号
            $smsParam['phoneNumber'] = [];
            $smsParam['phoneNumber'][] = $phone;

            //p($smsParam);die;

            $sendResult = TencentSmsFacade::sendSms($smsParam);

        }

        //阿里云发送短信验证码
        if($defaultServer === $this->server[1])
        {

        }

        return $sendResult;
   }

   /**
    * 发送注册验证码
    */
   public function sendUserRegisterCode($phone)
   {
        $defaultServer = Cache::store('redis')->get('sms');

        if(!$defaultServer)
        {
            throw new CommonException('SmsInitError');
        }

        $code = $this->initNumberCode();

        $redisResult = Redis::setex("sms-register:{$phone}",60*10, $code);

        if(!$redisResult)
        {
            throw new CommonException('SmsCodeSaveError');
        }

        $sendResult = 0;

        //腾讯云发送短信验证码
        if($defaultServer === $this->server[0])
        {

            $templateId = trim(Cache::store('redis')->get("tencent.sms.templateId.userRegister"));

            if(!$templateId)
            {
                throw new CommonException('TencentSmsTemplateIdError');
            }

            //模版id
            // [tencent.sms.templateId.userRegist] => 1882890
            // [tencent.sms.templateId.userLogin] => 1882891
            $smsParam['templateId'] = $templateId;
            //短信内容
            $smsParam['smsContent'] = [];
            $smsParam['smsContent'][] = $code;
            //手机号
            $smsParam['phoneNumber'] = [];
            $smsParam['phoneNumber'][] = $phone;

            //p($smsParam);die;

            $sendResult = TencentSmsFacade::sendSms($smsParam);
        }

        //阿里云发送短信验证码
        if($defaultServer === $this->server[1])
        {

        }

        return $sendResult;
   }

   /**
    * 获取存储在redis的验证码
    *
    * @param [type] $phone
    * @return void
    */
   public function getVerifyCode($phone)
   {
        $code = '';

        $isHasCOde = Redis::exists("sms:{$phone}");

        if($isHasCOde)
        {
            $code =  Redis::get("sms:{$phone}");
        }

        return $code;
   }

   /**
    * 获取用户注册码
    */
   public function getUserRegisterCode($phone)
   {
        $code = '';

        $isHasCOde = Redis::exists("sms-register:{$phone}");

        if($isHasCOde)
        {
            $code =  Redis::get("sms-register:{$phone}");
        }

        return $code;
   }
}
