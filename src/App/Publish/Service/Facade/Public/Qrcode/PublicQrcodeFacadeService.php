<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-06 20:33:33
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 22:11:54
 * @FilePath: \app\Service\Facade\Public\Qrcode\PublicQrcodeFacadeService.php
 */

namespace App\Service\Facade\Public\Qrcode;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

use App\Exceptions\Common\CommonException;


/**
 * @see \App\Facade\Public\Qrcode\PublicQrcodeFacade
 */
class PublicQrcodeFacadeService
{
   public function test()
   {
       echo "PublicQrcodeFacadeService test";
   }

   //跳转路径
   protected $redirectUrl;
   //logo路径
   protected $logoPath;
   //提示信息
   protected $noticeInfo;
   //二维码保存路径
   protected $qrcodePath;
   //生成二维码的模式
   // 1 保存二维码 2直接输出 3生成img标签url
   protected $mode;

   public function init($user)
   {

        $shareString = $user->invite_code;

        $configUrl = Cache::store('redis')->get('qrcode.redirectUrl');

        $this->redirectUrl = "{$configUrl}?share={$shareString}";

        $configLogopath = Cache::store('redis')->get('qrcode.logo');

        if(!$configLogopath)
        {
            throw new CommonException('QrcodeNotExistLogo');
        }

        $this->logoPath = storage_path()."/app/public/{$configLogopath}";

        $this->noticeInfo = Cache::store('redis')->get('qrcode.noticeTitle');

        //确保该目录可以存在
        Storage::disk('public')->makeDirectory("/user/album/{$user->id}");

        $this->qrcodePath = storage_path()."/app/public/user/album/{$user->id}/{$user->id}_qrcode.png";
   }

   /**
    * 生成用户二维码
    */
   public function makeQrcdoeWithUser($user,$mode = 1)
   {
        $this->init($user);

        $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([])
        ->data($this->redirectUrl)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(ErrorCorrectionLevel::High)
        ->size(300)
        ->margin(10)
        ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
        //->logoPath(storage_path().'/assets/symfony.png')
        ->logoPath($this->logoPath)
        ->logoResizeToWidth(50)
        ->logoPunchoutBackground(true)
        ->labelText($this->noticeInfo)
        ->labelFont(new NotoSans(20))
        ->labelAlignment(LabelAlignment::Center)
        ->validateResult(false)
        ->build();

        if($mode == 1)
        {
            // Save it to a file
            $result->saveToFile($this->qrcodePath);

            $checkReult = Storage::disk('public')->exists("/user/album/{$user->id}/{$user->id}_qrcode.png");

            if(!$checkReult)
            {
                throw new CommonException('MakeUserQrcodeError');
            }
        }

        if($mode == 2)
        {
            // Directly output the QR code
            header('Content-Type: '.$result->getMimeType());
            echo $result->getString();
        }

        if($mode == 3)
        {
            //Generate a data URI to include image data inline (i.e. inside an <img> tag)
            $dataUri = $result->getDataUri();
            return $dataUri;
        }
   }

}
