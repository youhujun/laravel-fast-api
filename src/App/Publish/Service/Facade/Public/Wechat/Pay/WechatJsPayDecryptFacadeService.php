<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 13:12:32
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 13:56:28
 * @FilePath: \app\Service\Facade\Public\Wechat\Pay\WechatJsPayDecryptFacadeService.php
 */

namespace App\Service\Facade\Public\Wechat\Pay;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Exceptions\Common\CommonException;

use WeChatPay\Crypto\Rsa;
use WeChatPay\Crypto\AesGcm;
use WeChatPay\Formatter;


/**
 * @see \App\Facade\Public\Wechat\Pay\WechatJsPayDecryptFacade
 */
class WechatJsPayDecryptFacadeService
{
   public function test()
   {
       echo "WechatJsPayDecryptFacadeService test";
   }

   /**
    * 将微信支付回调解密
    *
    * @param Request $request
    * @return void
    */
   public function decryptData($notifyData)
   {
        $inBodyResourceArray = [];
       /*  $inWechatpaySignature = '';// 请根据实际情况获取
        $inWechatpayTimestamp = '';// 请根据实际情况获取
        $inWechatpaySerial = '';// 请根据实际情况获取
        $inWechatpayNonce = '';// 请根据实际情况获取
        $inBody = '';// 请根据实际情况获取，例如: file_get_contents('php://input'); */

        [
            '$inWechatpaySignature' => $inWechatpaySignature,
            '$inWechatpayTimestamp' => $inWechatpayTimestamp,
            '$inWechatpaySerial' => $inWechatpaySerial,
            '$inWechatpayNonce' => $inWechatpayNonce,
            '$inBody' => $inBody
        ] = $notifyData;

        //Log::debug(['convert' => $notifyData]);

        $apiv3Key = trim(Cache::store('redis')->get('wechat.merchant.api_v3_key'));// 在商户平台上设置的APIv3密钥

        if(!$apiv3Key)
        {
            //throw new CommonException('apiV3KKeyNotExistsError');

            Log::debug(config('common_code.WechatApiV3KKeyNotExistsError'));
        }

        $wechatpayCertificate = storage_path('app/public/').trim(Cache::store('redis')->get('wechat.merchant.wechatpayCertificate'));

        if(!$wechatpayCertificate || !file_exists($wechatpayCertificate))
        {
            throw new CommonException('WechatMerchantWechatpayCertificateError');
        }
        // 根据通知的平台证书序列号，查询本地平台证书文件，
        // 假定为 `/path/to/wechatpay/inWechatpaySerial.pem`
        //$platformPublicKeyInstance = Rsa::from('file:///path/to/wechatpay/inWechatpaySerial.pem', Rsa::KEY_TYPE_PUBLIC);

        $wechatpayCertificate = 'file://'.$wechatpayCertificate;

        $platformPublicKeyInstance = Rsa::from($wechatpayCertificate, Rsa::KEY_TYPE_PUBLIC);

        // 检查通知时间偏移量，允许5分钟之内的偏移
        $timeOffsetStatus = 300 >= abs(Formatter::timestamp() - (int)$inWechatpayTimestamp);

        Log::debug(['$timeOffsetStatus' => $timeOffsetStatus]);

        $verifiedStatus = Rsa::verify(
            // 构造验签名串
            Formatter::joinedByLineFeed($inWechatpayTimestamp, $inWechatpayNonce, $inBody),
            $inWechatpaySignature,
            $platformPublicKeyInstance
        );

        Log::debug(['$verifiedStatus' => $verifiedStatus]);

        if ($timeOffsetStatus && $verifiedStatus)
        {
            // 转换通知的JSON文本消息为PHP Array数组
            $inBodyArray = (array)json_decode($inBody, true);
            // 使用PHP7的数据解构语法，从Array中解构并赋值变量
            ['resource' => [
                'ciphertext'      => $ciphertext,
                'nonce'           => $nonce,
                'associated_data' => $aad
            ]] = $inBodyArray;
            // 加密文本消息解密
            $inBodyResource = AesGcm::decrypt($ciphertext, $apiv3Key, $nonce, $aad);
            // 把解密后的文本转换为PHP Array数组
            $inBodyResourceArray = (array)json_decode($inBodyResource, true);
            // print_r($inBodyResourceArray);// 打印解密后的结果
        }

        return $inBodyResourceArray;
   }
}
