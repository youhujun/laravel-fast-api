<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 13:35:46
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 15:37:08
 * @FilePath: \database\seeders\System\SystemConfig\SystemConfigSeeder.php
 */

namespace Database\Seeders\System\SystemConfig;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $systemConfigData = [

             //微信公众号
            ['item_type'=>20,'item_label'=>'wechat.official.appId','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'微信公众号appid','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'wechat.official.appSercet','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'微信公众号秘钥','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'wechat.official.auth_redirect_url','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'微信公众号授权回调链接','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

             //微信商户
            ['item_type'=>20,'item_label'=>'wechat.merchant.merchantId','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'微信商户Id','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'wechat.merchant.api_v3_key','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'用户加密解密','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'wechat.merchant.merchantSerialNumber','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'商户API证书序列号','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>40,'item_label'=>'wechat.merchant.merchantPrivateKey','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'商户私钥文件路径','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>40,'item_label'=>'wechat.merchant.wechatpayCertificate','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'微信支付平台证书文件路径','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'wechat.merchant.notifyUrl.JsPayNotifyUrl','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'JsPay支付回调通知地址 ','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

             //uni_app 一键登录
            ['item_type'=>20,'item_label'=>'uni_app.univerifyLogin.sercret','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'uni_app一键登录自定义秘钥','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'uni_app.univerifyLogin.url','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'uni_app一键登录云函数地址','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            //1 默认短信平台设置为腾讯云
            ['item_type'=>20,'item_label'=>'sms','item_value'=>'tencent','item_price'=>0,'item_path'=>'','item_introduction'=>'短信平台','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            //短信配置
            ['item_type'=>20,'item_label'=>'tencent.secretId','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'腾讯应用id','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'tencent.secretKey','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'腾讯应用key','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'tencent.sms.ap_config','item_value'=>'ap-beijing','item_price'=>0,'item_path'=>'','item_introduction'=>'北京地域','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'tencent.sms.sdkAppId','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'腾讯云短信应用ID选项-默认','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'tencent.sms.singName','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'腾讯云短信签名选项-默认','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'tencent.sms.templateId.userRegister','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'短信模版-用户注册','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'tencent.sms.templateId.userLogin','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'短信模版-用户登录','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'tencent.sms.PhonePre','item_value'=>'+86','item_price'=>0,'item_path'=>'','item_introduction'=>'腾讯云短信手机号前缀选项(国内)','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            //腾讯地图
            ['item_type'=>20,'item_label'=>'tencent.map.key','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'腾讯地图key','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'tencent.map.regionUrl','item_value'=>'https://apis.map.qq.com/ws/geocoder/v1/','item_price'=>0,'item_path'=>'','item_introduction'=>'逆地址解析接口','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            //二维码
            ['item_type'=>20,'item_label'=>'qrcode.redirectUrl','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'二维码跳转链接','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>40,'item_label'=>'qrcode.logo','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'二维码logo','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>20,'item_label'=>'qrcode.noticeTitle','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'二维码提示字','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            //存储桶
             ['item_type'=>20,'item_label'=>'cloud.store','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'云存储平台','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

             ['item_type'=>20,'item_label'=>'qiniu.accessKey','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'七牛云的accessKey','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

             ['item_type'=>20,'item_label'=>'qiniu.secretKey','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'七牛云的secretKey','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

             ['item_type'=>20,'item_label'=>'qiniu.cdn_url','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'cdn加速域名','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],

            ['item_type'=>10,'item_label'=>'qiniu.bucket.default','item_value'=>'','item_price'=>0,'item_path'=>'','item_introduction'=>'七牛云的存储桶','created_time'=>time(),'created_at'=>date('Y-m-d H:i:s',time()),'sort'=>100],



         ];


         DB::table('system_config')->insert($systemConfigData);
    }
}
