<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 09:52:28
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 11:07:27
 * @FilePath: \app\Service\Facade\Public\Wechat\Pay\WechatJsPayFacadeService.php
 */

namespace App\Service\Facade\Public\Wechat\Pay;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use GuzzleHttp\Exception\RequestException;
use WechatPay\GuzzleMiddleware\WechatPayMiddleware;
use WechatPay\GuzzleMiddleware\Util\PemUtil;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

use App\Exceptions\Common\CommonException;

/**
 * @see \App\Facade\Public\Wechat\Pay\WechatJsPayFacade
 */
class WechatJsPayFacadeService
{
   public function test()
   {
       echo "WechatJsPayFacadeService test";
   }

    // 商户号
   private $merchantId;

   // 商户API证书序列号
   private $merchantSerialNumber;

   // 商户私钥文件路径
   private $merchantPrivateKey;

   // 微信支付平台证书文件路径
   private $wechatpayCertificate;

   //Guzzle HTTP Client
   private $client;

   //微信公众号id
   private $official_appid;

   //支付回调通知地址
   private $notifyUrl;

   /**
    * 初始化
    *
    * @return void
    */
   public function init()
   {
        $this->initClient();

        $this->OtherInit();
   }


   /**
    * 客户端初始化
    *
    * @return void
    */
   public function initClient()
   {
        // 商户相关配置，
        $this->merchantId = trim(Cache::store('redis')->get('wechat.merchant.merchantId'));

        if(!$this->merchantId)
        {
            throw new CommonException('WechatMerchantMerchantIdError');
        }

        $this->merchantSerialNumber =  trim(Cache::store('redis')->get('wechat.merchant.merchantSerialNumber'));

        if(!$this->merchantSerialNumber)
        {
            throw new CommonException('WechatMerchantMerchantSerialNumberError');
        }

        // 注意 linux下 要给到 777 权限
        //apiclient_key.pem
        $merchantPrivateKeyPath = storage_path('app/public/').trim(Cache::store('redis')->get('wechat.merchant.merchantPrivateKey'));

        if(!$merchantPrivateKeyPath || !file_exists($merchantPrivateKeyPath))
        {
            throw new CommonException('WechatMerchantMerchantPrivateKeyError');
        }

        $this->merchantPrivateKey = PemUtil::loadPrivateKey($merchantPrivateKeyPath);

        //wechatpay.pem
        $wechatpayCertificate = storage_path('app/public/').trim(Cache::store('redis')->get('wechat.merchant.wechatpayCertificate'));

        if(!$wechatpayCertificate || !file_exists($wechatpayCertificate))
        {
            throw new CommonException('WechatMerchantWechatpayCertificateError');
        }

        //微信支付平台配置
        $this->wechatpayCertificate = PemUtil::loadCertificate($wechatpayCertificate);

        // 构造一个WechatPayMiddleware
        $wechatpayMiddleware = WechatPayMiddleware::builder()
            ->withMerchant($this->merchantId, $this->merchantSerialNumber, $this->merchantPrivateKey) // 传入商户相关配置
            ->withWechatPay([ $this->wechatpayCertificate ]) // 可传入多个微信支付平台证书，参数类型为array
            ->build();

        // 将WechatPayMiddleware添加到Guzzle的HandlerStack中
        $stack = HandlerStack::create();
        $stack->push($wechatpayMiddleware, 'wechatpay');

        // 创建Guzzle HTTP Client时，将HandlerStack传入，接下来，正常使用Guzzle发起API请求，WechatPayMiddleware会自动地处理签名和验签
        $this->client = new Client(['handler' => $stack]);

        //p($client);
        return $this->client;
   }

   /**
    * 其他需要初始化的配置
    *
    * @return void
    */
   public function OtherInit()
   {
        $this->official_appid = trim(Cache::store('redis')->get('wechat.official.appId'));

        if(!$this->official_appid)
        {
            throw new CommonException('WechatOfficialAppIdError');
        }

        $this->notifyUrl = trim(Cache::store('redis')->get('wechat.merchant.notifyUrl.JsPayNotifyUrl'));

        if(!$this->notifyUrl)
        {
            throw new CommonException('WecahtMerchantNotifyUrlJsPayNotifyUrlError');
        }
   }

   /**
    * JSAPI下单
    *
    * @param [type] $jsonData
    * @return void
    */
   public function prePayOrder($jsonData)
   {
        $result = code(config('common_code.PrePayOrderByWechatJsError'));

        $this->init();

        $preJsonData = [
            'appid'=>$this->official_appid,
            "mchid" =>$this->merchantId,
            'notify_url'=>$this->notifyUrl
        ];

        $arrayData = array_merge( $preJsonData,$jsonData);

            /*  [
                //应用ID 1-32
                "appid" =>  "wx09f89f9e9d5f72ba",//"wxd678efh567hg6787",
                //直连商户号 -132
                "mchid" =>$this->merchantId, //"1230000109",
                //商品描述  1-127
                "description" => "Image形象店-深圳腾大-QQ公仔",
                //商户订单号 6-32
                "out_trade_no" =>"SC20230707141550168871055064a7ad", //"1217752501201407033233368018",
                //通知地址
                "notify_url" => "https://api.youhujun.com/api/payNotify", //"https://www.weixin.qq.com/wxpay/pay.php",
                //订单金额   订单金额信息
                    "amount" => [
                    //总金额  订单总金额，单位为分。 int
                    "total" => 100,
                    //货币类型  CNY：人民币，境内商户号仅支持人民币。
                    "currency" => "CNY",
                ],
                // 支付者 用户标识  用户在直连商户appid下的唯一标识。 下单前需获取到用户的Openid
                "payer" => [
                    "openid" =>"oYFqa5nW_bn2icDWNBi4xEXpRf5E", //"oUpF8uMuAJO_M2pxb1Q9zNjWeS6o",
                ],
                //附加数据 1-128 附加数据，在查询API和支付通知中原样返回，可作为自定义参数使用，实际情况下只有支付完成状态才会返回该字段
                "attach" => "自定义数据说明",

                //交易结束时间  遵循rfc3339标准格式
                //"time_expire" => date('Y-m-d\TH:i:sP',time()),//"2018-06-08T10:34:56+08:00",

                //订单优惠标记
                //"goods_tag" => "WXG",

                //优惠功能
                "detail" => [
                    //商品小票ID
                    "invoice_id" => "wx123",
                    //单品列表
                    "goods_detail" => [
                        [
                            //商品名称
                            "goods_name" => "iPhoneX 256G",
                            //微信支付商品编码
                            "wechatpay_goods_id" => "1001",
                            //商品数量
                            "quantity" => 1,
                            //商户侧商品编码
                            "merchant_goods_id" => "商品编码",
                            //商品单价
                            "unit_price" => 828800,
                        ],
                        [
                            "goods_name" => "iPhoneX 256G",
                            "wechatpay_goods_id" => "1001",
                            "quantity" => 1,
                            "merchant_goods_id" => "商品编码",
                            "unit_price" => 828800,
                        ],
                    ],
                    //订单原价
                    "cost_price" => 608800,
                ],
                //场景信息
                    "scene_info" => [
                    "store_info" => [
                        "address" => "广东省深圳市南山区科技中一道10000号",
                        "area_code" => "440305",
                        "name" => "腾讯大厦分店",
                        "id" => "0001",
                    ],
                    "device_id" => "013467007045764",
                    "payer_client_ip" => "14.23.150.211",
                ]
            ], */

        try
        {
            $resp = $this->client->request(
                'POST',
                'https://api.mch.weixin.qq.com/v3/pay/transactions/jsapi', //请求URL
                [
                    // JSON请求体
                    'json' =>$arrayData,
                    'headers' => [ 'Accept' => 'application/json' ]
                ]
            );
            $statusCode = $resp->getStatusCode();
            if ($statusCode == 200)
            { //处理成功
                //echo "success,return body = " . $resp->getBody()->getContents()."\n";
                //success,return body = {"prepay_id":"wx1916534311771708341ae662f3b2220000"}
                $resultString = $resp->getBody()->getContents();

                $resultObject = json_decode($resultString);

                $checkResult = property_exists($resultObject,'prepay_id');

                if(!$checkResult)
                {
                    throw new CommonException('PrePayOrderByWechatJsError');
                }

                $prepay_id = $resultObject->prepay_id;

                $timeStamp =time();

                $nonceStr = uniqid();

                $content = "{$this->official_appid}\n{$timeStamp}\n{$nonceStr}\nprepay_id={$prepay_id}\n";

                $signature = false;

                openssl_sign($content, $signature, $this->merchantPrivateKey,"SHA256");

                $paySign = base64_encode($signature);

                return ['prepay_id'=>$prepay_id,'appId'=>$this->official_appid,'timeStamp'=>$timeStamp,'nonceStr'=>$nonceStr,'paySign'=>$paySign];
            }
            else if ($statusCode == 204)
            { //处理成功，无返回Body
                echo "success";
            }
        }
        catch (RequestException $e)
        {
            // 进行错误处理
            echo $e->getMessage()."\n";
            if ($e->hasResponse())
            {
                echo "failed,resp code = " . $e->getResponse()->getStatusCode() . " return body = " . $e->getResponse()->getBody() . "\n";
            }
            return;
        }

   }


}
