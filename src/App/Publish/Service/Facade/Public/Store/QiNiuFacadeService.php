<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-17 12:19:11
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-18 09:59:07
 * @FilePath: \app\Service\Facade\Public\Store\QiNiuFacadeService.php
 */

namespace App\Service\Facade\Public\Store;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use  App\Exceptions\Common\CommonException;

//引入鉴权类
use \Qiniu\Auth as QiniuAuth;
// 引入上传类
use \Qiniu\Storage\UploadManager;
//文件管理
use \Qiniu\Storage\BucketManager;

/**
 * @see \App\Facade\Public\Store\QiNiuFacade
 */
class QiNiuFacadeService
{
   public function test()
   {
       echo "QiNiuFacadeService test";
   }

   private  $accessKey;
   private  $secretKey;
   protected $bucket;

   protected $auth;
   protected $uploadToken;
   protected $cdnUrl;


   public function __construct()
   {

        $this->accessKey = trim(Cache::store('redis')->get('qiniu.accessKey'));

        if(!$this->accessKey)
        {
             throw new CommonException('QiNiuAccessKeyError');
        }

        $this->secretKey = trim(Cache::store('redis')->get('qiniu.secretKey'));

        if(!$this->secretKey)
        {
             throw new CommonException('QiNiuSecretKeyError');
        }

        $this->auth = new QiniuAuth($this->accessKey, $this->secretKey);

   }

   /**
    * 获取上传凭证
    */
   protected function getToken()
   {
        $this->bucket = trim(Cache::store('redis')->get('qiniu.bucket.default'));

        if(!$this->bucket)
        {
            throw new CommonException('QiNiuDefaultBucketError');
        }

        //上传凭证有效时间
        $expires = 7200;
        //覆盖上传的文件
        //$keyToOverwrite = 'qiniu.mp4';
        $keyToOverwrite = null;
        //自定义返回值
        //$policy = null;
        $returnBody = '{"key":"$(key)","hash":"$(etag)","fsize":$(fsize),"name":"$(fname)"}';
        $policy = array(
            'returnBody' => $returnBody
        );

        $this->uploadToken = $this->auth->uploadToken($this->bucket,$keyToOverwrite, $expires, $policy, true);
   }

   /**
    * 七牛云上传文件
    *
    * @param  [type] $filePath 文件路径
    * @param  [type] $savePath 保存路径
    */
   public function uploadFile($filePath,$savePath)
   {
        $this->getToken();
         //var_dump($upToken);
        // 要上传文件的本地路径
        //$filePath = public_path('storage/config/file/config/other_005.jpg');
        // 上传到存储后保存的文件名
        //$key = 'test/test/lucky.jpg';
       //$key = 'test/test/other_005.jpg';
        $key = $savePath;
        // 初始化 UploadManager 对象并进行文件的上传。
        $uploadMgr = new UploadManager();
        // 调用 UploadManager 的 putFile 方法进行文件的上传。
        list($result, $error) = $uploadMgr->putFile($this->uploadToken, $key, $filePath, null, 'application/octet-stream', true, null, 'v2');

        if($error)
        {
            Log::debug(['QiNiuUploadFileError'=>'七牛云上传文件失败!','Error'=>$error]);
        }

        return $result;
   }

   /**
    * 获取私有空间的链接
    * @param  [type] $savePath
    */
   public function getPrivateFileUrl($savePath)
   {
        $cdnUrl = trim(Cache::store('redis')->get('qiniu.cdn_url'));

        if(!$cdnUrl)
        {
            throw new CommonException('QiNiuCdnUrlError');
        }

        // 私有空间中的外链 http://<domain>/<file_key>
        $baseUrl = $cdnUrl.$savePath;
        // 对链接进行签名
        $signedUrl = $this->auth->privateDownloadUrl($baseUrl);

        return $signedUrl;
   }

   /**
    * 获取公有链接
    */
   public function getPublicFileUrl($savePath)
   {
        $cdnUrl = trim(Cache::store('redis')->get('qiniu.cdn_url'));

        if(!$cdnUrl)
        {
            throw new CommonException('QiNiuCdnUrlError');
        }

        // 私有空间中的外链 http://<domain>/<file_key>
        $baseUrl = $cdnUrl.$savePath;

        return $baseUrl;
   }
}
