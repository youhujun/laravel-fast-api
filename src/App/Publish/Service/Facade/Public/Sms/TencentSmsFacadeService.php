<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-28 18:22:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-30 16:53:17
 * @FilePath: \app\Service\Facade\Public\Sms\TencentSmsFacadeService.php
 */


namespace App\Service\Facade\Public\Sms;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Exceptions\Common\CommonException;

// 导入对应产品模块的client
use TencentCloud\Sms\V20210111\SmsClient;
// 导入要请求接口对应的Request类
use TencentCloud\Sms\V20210111\Models\SendSmsRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Credential;
// 导入可选配置类
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;


/**
 * @see \App\Facade\Public\Sms\TencentSmsFacade
 */
class TencentSmsFacadeService
{
   public function test()
   {
       echo "TencentSmsFacadeService test";
   }

    //腾讯云应用 id和key
   protected $secretId;
   protected $secretKey;

   //短信验证码
   //地域
   protected $smsApConfig;
   //sdkAppId
   protected $smsSdkAppId;
   //短信签名
   protected $signName;
   //短信模版id
   protected $templateId;
   //手机号前缀
   protected $phonePre;
   //curl请求 GET|POST
   protected $curlMethods;
   //sing签名加密方式 'TC3-HMAC-SHA256'
   protected $singMethods;



   /**
    * 初始化
    *
    * @return void
    */
   public function init()
   {

      $this->secretId = trim(Cache::store('redis')->get('tencent.secretId'));

      if(!$this->secretId)
      {
         throw new CommonException('TencentSecretIdError');
      }

      $this->secretKey = trim(Cache::store('redis')->get('tencent.secretKey'));

      if(!$this->secretKey)
      {
        throw new CommonException('TencentSecretKeyError');
      }
   }

   /**
    * 发送短息验证码
    *
    * @param array $smsContent  模板内容同包含验证码
    * @param array $phoneNumber 手机号
    * @param string $smsApConfig 地域
    * @param string $smsSdkAppId appID
    * @param string $signName  签名模板
    * @param string $templateId 短信模板id
    * @param string $phonePre  手机号前缀
    * @return void
    */
   public function sendSms($smsParam)
   {
        //定义发送结果
        $sendResult = 0;

        $this->init();

        //p($smsParam);die;

        ['smsContent'=>$smsContent,'phoneNumber'=>$phoneNumber] = $smsParam;

        if(!isset($smsParam['smsContent']) || count($smsParam['smsContent']) == 0)
        {
            throw new CommonException('TencentSmsContentError');
        }

        if(!isset($smsParam['phoneNumber']) || count($smsParam['phoneNumber']) == 0)
        {
            throw new CommonException('TencentSmsPhoneNumberError');
        }

        if(isset($smsParam['smsApConfig']) )
        {
            $smsApConfig = $smsParam['smsApConfig'];
        }

        if(isset($smsParam['curlMethods']) )
        {
            $curlMethods = $smsParam['curlMethods'];
        }

        if(isset($smsParam['signMethods']) )
        {
            $signMethods = $smsParam['signMethods'];
        }

        if(isset($smsParam['smsSdkAppId']) )
        {
            $smsSdkAppId = $smsParam['smsSdkAppId'];
        }

        if(isset($smsParam['signName']) )
        {
            $signName = $smsParam['signName'];
        }

        if(isset($smsParam['phonePre']) )
        {
            $phonePre = $smsParam['phonePre'];
        }

         if(isset($smsParam['templateId']) )
        {
            $templateId = $smsParam['templateId'];
        }

        if(!isset($smsApConfig) || empty($smsApConfig))
        {
            $smsApConfig = trim(Cache::store('redis')->get("tencent.sms.ap_config"));

            if(!$smsApConfig)
            {
                throw new CommonException('TencentSmsApConfigError');
            }
        }

        if(!isset($smsSdkAppId) || empty($smsSdkAppId))
        {
            $smsSdkAppId =  trim(Cache::store('redis')->get("tencent.sms.sdkAppId"));

            if(!$smsSdkAppId)
            {
                throw new CommonException('TencentSmsSdkAppIdError');
            }
        }

        if(!isset($signName) || empty($signName))
        {
            $signName =  trim(Cache::store('redis')->get("tencent.sms.singName"));

            if(!$signName)
            {
                throw new CommonException('TencentSmsSignNameError');
            }
        }

        if(!isset($templateId) || empty($templateId))
        {
            $templateId = trim(Cache::store('redis')->get("tencent.sms.templateId.userLogin"));

            if(!$templateId)
            {
                throw new CommonException('TencentSmsTemplateIdError');
            }
        }


        if(!isset($phonePre) || empty($phonePre))
        {
            $phonePre = trim(Cache::store('redis')->get("tencent.sms.PhonePre"));

            if(!$phonePre)
            {
                throw new CommonException('TencentSmsPhonePreError');
            }
        }

        if(!isset($curlMethods) || empty($curlMethods))
        {
            $curlMethods = 'POST';
        }

        if(!isset($singMethods) || empty($singMethods))
        {
            $singMethods = 'TC3-HMAC-SHA256';
        }

        $this->smsApConfig = $smsApConfig;
        $this->smsSdkAppId = $smsSdkAppId;
        $this->signName = $signName;
        $this->templateId = $templateId;
        $this->phonePre =  $phonePre;
        $this->curlMethods = $curlMethods;
        $this->singMethods = $singMethods;

        //p($this);die;

        //p($phoneNumber);die;

        foreach ($phoneNumber as $key => &$value)
        {
            $value =  $this->phonePre.$value;
        }

        //p($phoneNumber);die;

        try {
            // 实例化一个证书对象，入参需要传入腾讯云账户 SecretId，SecretKey
            // 为了保护密钥安全，建议将密钥设置在环境变量中或者配置文件中。
            // 硬编码密钥到代码中有可能随代码泄露而暴露，有安全隐患，并不推荐。
            // SecretId、SecretKey 查询: https://console.cloud.tencent.com/cam/capi
            // $cred = new Credential("SecretId", "SecretKey");
           // $cred = new Credential(getenv("TENCENTCLOUD_SECRET_ID"), getenv("TENCENTCLOUD_SECRET_KEY"));

            //    p( $this->secretId);
            //    p( $this->secretKey);die;
            $cred = new Credential($this->secretId, $this->secretKey);

            // 实例化一个http选项，可选的，没有特殊需求可以跳过
            $httpProfile = new HttpProfile();
            // 配置代理（无需要直接忽略）
            // $httpProfile->setProxy("https://ip:port");
            //$httpProfile->setReqMethod("POST");  // get请求(默认为post请求)
            $httpProfile->setReqMethod($this->curlMethods);  // get请求(默认为post请求)

            //$httpProfile->setReqMethod($curlMethods);  // get请求(默认为post请求)
            $httpProfile->setReqTimeout(10);    // 请求超时时间，单位为秒(默认60秒)
            $httpProfile->setEndpoint("sms.tencentcloudapi.com");  // 指定接入地域域名(默认就近接入)

            // 实例化一个client选项，可选的，没有特殊需求可以跳过
            $clientProfile = new ClientProfile();
            $clientProfile->setSignMethod($singMethods);  // 指定签名算法
            //$clientProfile->setSignMethod($this->singMethods);  // 指定签名算法
            $clientProfile->setHttpProfile($httpProfile);

            // 实例化要请求产品(以sms为例)的client对象,clientProfile是可选的
            // 第二个参数是地域信息，可以直接填写字符串ap-guangzhou，支持的地域列表参考 https://cloud.tencent.com/document/api/382/52071#.E5.9C.B0.E5.9F.9F.E5.88.97.E8.A1.A8
            //$client = new SmsClient($cred, "ap-beijing", $clientProfile);
           // p( $this->smsApConfig);die;
            $client = new SmsClient($cred,  $this->smsApConfig, $clientProfile);


            // 实例化一个 sms 发送短信请求对象,每个接口都会对应一个request对象。
            $req = new SendSmsRequest();


            /* 填充请求参数,这里request对象的成员变量即对应接口的入参
            * 您可以通过官网接口文档或跳转到request对象的定义处查看请求参数的定义
            * 基本类型的设置:
            * 帮助链接：
            * 短信控制台: https://console.cloud.tencent.com/smsv2
            * 腾讯云短信小助手: https://cloud.tencent.com/document/product/382/3773#.E6.8A.80.E6.9C.AF.E4.BA.A4.E6.B5.81 */


            /* 短信应用ID: 短信SdkAppId在 [短信控制台] 添加应用后生成的实际SdkAppId，示例如1400006666 */
            // 应用 ID 可前往 [短信控制台](https://console.cloud.tencent.com/smsv2/app-manage) 查看
            //$req->SmsSdkAppId = "1400787878";
            $req->SmsSdkAppId = $this->smsSdkAppId;
            /* 短信签名内容: 使用 UTF-8 编码，必须填写已审核通过的签名 */
            // 签名信息可前往 [国内短信](https://console.cloud.tencent.com/smsv2/csms-sign) 或 [国际/港澳台短信](https://console.cloud.tencent.com/smsv2/isms-sign) 的签名管理查看
            //$req->SignName = "腾讯云";
            $req->SignName =  $this->signName;
            /* 模板 ID: 必须填写已审核通过的模板 ID */
            // 模板 ID 可前往 [国内短信](https://console.cloud.tencent.com/smsv2/csms-template) 或 [国际/港澳台短信](https://console.cloud.tencent.com/smsv2/isms-template) 的正文模板管理查看
            // $req->TemplateId = "1882890";
            $req->TemplateId = $this->templateId;
            /* 模板参数: 模板参数的个数需要与 TemplateId 对应模板的变量个数保持一致，若无模板参数，则设置为空*/
            //$req->TemplateParamSet = array("1234");
            $req->TemplateParamSet = $smsContent;
            /* 下发手机号码，采用 E.164 标准，+[国家或地区码][手机号]
            * 示例如：+8613711112222， 其中前面有一个+号 ，86为国家码，13711112222为手机号，最多不要超过200个手机号*/
            //$req->PhoneNumberSet = array("+8613711112222");
            $req->PhoneNumberSet = $phoneNumber;
            /* 用户的 session 内容（无需要可忽略）: 可以携带用户侧 ID 等上下文信息，server 会原样返回 */
            $req->SessionContext = "";
            /* 短信码号扩展号（无需要可忽略）: 默认未开通，如需开通请联系 [腾讯云短信小助手] */
            $req->ExtendCode = "";
            /* 国内短信无需填写该项；国际/港澳台短信已申请独立 SenderId 需要填写该字段，默认使用公共 SenderId，无需填写该字段。注：月度使用量达到指定量级可申请独立 SenderId 使用，详情请联系 [腾讯云短信小助手](https://cloud.tencent.com/document/product/382/3773#.E6.8A.80.E6.9C.AF.E4.BA.A4.E6.B5.81)。*/
            $req->SenderId = "";


            // 通过client对象调用SendSms方法发起请求。注意请求方法名与请求对象是对应的
            // 返回的resp是一个SendSmsResponse类的实例，与请求对象对应
            $resp = $client->SendSms($req);

            if(is_object($resp))
            {
                if($resp->SendStatusSet[0]->Code === "Ok")
                {
                    $sendResult = 1;
                }
            }
            else
            {
                Log::debug(['TencentSendSmsResp'=>$resp]);

                throw new CommonException('TencentSmsSendError');
            }

            return $sendResult;


            // 输出json格式的字符串回包
            //print_r($resp->toJsonString());


            // 也可以取出单个值。
            // 您可以通过官网接口文档或跳转到response对象的定义处查看返回字段的定义
            //print_r($resp->TotalCount);


            /* 当出现以下错误码时，快速解决方案参考
            * [FailedOperation.SignatureIncorrectOrUnapproved](https://cloud.tencent.com/document/product/382/9558#.E7.9F.AD.E4.BF.A1.E5.8F.91.E9.80.81.E6.8F.90.E7.A4.BA.EF.BC.9Afailedoperation.signatureincorrectorunapproved-.E5.A6.82.E4.BD.95.E5.A4.84.E7.90.86.EF.BC.9F)
            * [FailedOperation.TemplateIncorrectOrUnapproved](https://cloud.tencent.com/document/product/382/9558#.E7.9F.AD.E4.BF.A1.E5.8F.91.E9.80.81.E6.8F.90.E7.A4.BA.EF.BC.9Afailedoperation.templateincorrectorunapproved-.E5.A6.82.E4.BD.95.E5.A4.84.E7.90.86.EF.BC.9F)
            * [UnauthorizedOperation.SmsSdkAppIdVerifyFail](https://cloud.tencent.com/document/product/382/9558#.E7.9F.AD.E4.BF.A1.E5.8F.91.E9.80.81.E6.8F.90.E7.A4.BA.EF.BC.9Aunauthorizedoperation.smssdkappidverifyfail-.E5.A6.82.E4.BD.95.E5.A4.84.E7.90.86.EF.BC.9F)
            * [UnsupportedOperation.ContainDomesticAndInternationalPhoneNumber](https://cloud.tencent.com/document/product/382/9558#.E7.9F.AD.E4.BF.A1.E5.8F.91.E9.80.81.E6.8F.90.E7.A4.BA.EF.BC.9Aunsupportedoperation.containdomesticandinternationalphonenumber-.E5.A6.82.E4.BD.95.E5.A4.84.E7.90.86.EF.BC.9F)
            * 更多错误，可咨询[腾讯云助手](https://tccc.qcloud.com/web/im/index.html#/chat?webAppId=8fa15978f85cb41f7e2ea36920cb3ae1&title=Sms)
            */
        }
        catch(TencentCloudSDKException $e)
        {
           // echo $e;
           Log::debug(['TencentSendSmsError'=>$e]);

           throw new CommonException('TencentSmsError');
        }


   }
}
