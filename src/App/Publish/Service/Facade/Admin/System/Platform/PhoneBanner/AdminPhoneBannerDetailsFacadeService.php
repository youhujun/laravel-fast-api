<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 22:27:34
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 22:59:32
 * @FilePath: \app\Service\Facade\Admin\System\Platform\PhoneBanner\AdminPhoneBannerDetailsFacadeService.php
 */

namespace App\Service\Facade\Admin\System\Platform\PhoneBanner;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\System\PhoneBannner;

/**
 * @see \App\Facade\Admin\System\Platform\PhoneBanner\AdminPhoneBannerDetailsFacade
 */
class AdminPhoneBannerDetailsFacadeService
{
   public function test()
   {
       echo "AdminPhoneBannerDetailsFacadeService test";
   }

   protected  $responseMessage = [
        'Picture'=>'更新轮播图成功!',
        'Url'=>'更新图片链接成功!',
        'Sort'=>'更新图片排序成功!',
        'RemarkInfo'=>'更新备注信息成功!'
   ];

   /**
    * 公共的更新轮播图
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   protected function updatePhoneBannerCommon($validated,$admin,$errorKeyName)
   {
        $result = code(config("code.UpdatePhoneBanner{$errorKeyName}Error"));

        $phoneBanner = PhoneBannner::find($validated['id']);

        if(!optional($phoneBanner))
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$phoneBanner ->revision];

        $phoneBanner->admin_id = $admin->id;

        foreach ( $validated as $key => $value)
        {
            if($key === 'id')
            {
                $where[] = ['id','=',$value];
                continue;
            }

            $updateData[$key] = $value;
        }

        $updateData['revision'] = $phoneBanner ->revision + 1;

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $updateData['updated_time'] = time();

        $phoneBannerResult = PhoneBannner::where($where)->update($updateData);

        if(!$phoneBannerResult)
        {
           throw new CommonException("updatePhoneBanner{$errorKeyName}Error");
        }

        $eventResult = CommonEvent::dispatch($admin,$phoneBanner,"UpdatePhoneBanner{$errorKeyName}");

        $result = code(['code'=>0,'msg'=>$this->responseMessage[$errorKeyName]]);

        return $result;
   }

   /**
    * 更新图片相册
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function updatePhoneBannerPicture($validated,$admin)
   {
        $result = $this->updatePhoneBannerCommon($validated,$admin,'Picture');

        return $result;
   }

   /**
    * 修改轮播图跳转
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function updatePhoneBannerUrl($validated,$admin)
   {
        $result = $this->updatePhoneBannerCommon($validated,$admin,'Url');

        return $result;
   }

   /**
    * 修改轮播图排序
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function updatePhoneBannerSort($validated,$admin)
   {
        $result = $this->updatePhoneBannerCommon($validated,$admin,'Sort');

        return $result;
   }

   /**
    * 修改轮播图备注
    *
    * @param [type] $validated
    * @param [type] $admin
    * @return void
    */
   public function updatePhoneBannerBakInfo($validated,$admin)
   {
        $result = $this->updatePhoneBannerCommon($validated,$admin,'RemarkInfo');

        return $result;
   }
}
