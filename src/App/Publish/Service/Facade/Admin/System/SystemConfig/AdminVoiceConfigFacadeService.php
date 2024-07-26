<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-19 10:23:21
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-20 09:12:58
 * @FilePath: \app\Service\Facade\Admin\System\SystemConfig\AdminVoiceConfigFacadeService.php
 */

namespace App\Service\Facade\Admin\System\SystemConfig;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

use App\Service\Facade\Trait\QueryService;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\System\SystemVoiceConfig;

use App\Http\Resources\System\SystemConfig\Admin\SystemVoiceConfigResouce;
use App\Http\Resources\System\SystemConfig\Admin\SystemVoiceConfigCollection;

use App\Facade\Public\Excel\PublicExcelFacade;



/**
 * @see \App\Facade\Admin\System\SystemConfig\AdminVoiceConfigFacade
 */
class AdminVoiceConfigFacadeService
{
   public function test()
   {
       echo "AdminVoiceConfigFacadeService test";
   }

   use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

   protected static $searchItem = [
        'voice_title',
        'channle_name',
        'channle_event'
    ];

   protected static $storage_public_path = DIRECTORY_SEPARATOR.'app'. DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR;


   /**
    * 获取所有提示配置
    *
    * @param  [type] $validated
    * @param  [type] $admin
    */
   public function getAllSystemVoiceConfig($validated,$admin)
   {
        $result = code(config('admin_cdoe.GetSystemVoiceConfigError'));

        $sytstemVoiceConfigList = SystemVoiceConfig::all();

        //p($sytstemVoiceConfigList);die;

         if(\optional($sytstemVoiceConfigList))
        {
            $download = null;

            $result = new SystemVoiceConfigCollection($sytstemVoiceConfigList,['code'=> 0,'msg'=>'获取提示配置成功'],$download);
        }

        return  $result;
   }
    /**
     * 查询
     *
     * @param [type] $validated
     * @return void
     */
    public function getVoiceConfig($validated,$admin)
    {

       $result = code(config('admin_cdoe.GetSystemVoiceConfigError'));

       $this->setQueryOptions($validated);

       $query = SystemVoiceConfig::query();


       if(isset($validated['findSelectIndex']))
       {
            if(isset($validated['find']) && !empty($validated['find']))
            {
               $this->where[] = [self::$searchItem[$validated['findSelectIndex']],'like',"%{$validated['find']}%"];

               $query = $query->where($this->where);
            }
       }

        if(isset($validated['timeRange']) && \count($validated['timeRange']) > 0)
        {
            if(isset($validated['timeRange'][0]) && !empty($validated['timeRange'][0]))
            {
                $this->whereBetween[] = [\strtotime($validated['timeRange'][0])];
            }

            if(isset($validated['timeRange'][1]) && !empty($validated['timeRange'][1]))
            {
                $this->whereBetween[] = [\strtotime($validated['timeRange'][1])];
            }

            if(isset($this->whereBetween) && count($this->whereBetween) > 0)
            {
                $query->whereBetween('created_time',$this->whereBetween);
            }

        }

        if(isset($validated['sortType']))
        {
            $sortType = $validated['sortType'];

            $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }

        $download = null;

        $sytstemVoiceConfigList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

       // p($sytstemVoiceConfigList);die;

        if(\optional($sytstemVoiceConfigList))
        {
            $result = new SystemVoiceConfigCollection($sytstemVoiceConfigList,['code'=> 0,'msg'=>'获取提示配置成功'],$download);
        }

        return  $result;
    }

    /**
     * 添加
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function addVoiceConfig($validated,$admin)
    {
        $result = code(config('admin_cdoe.AddSystemVoiceConfigError'));

        $systemVoiceConfig = new SystemVoiceConfig;

        $isUseCloudStore = Cache::store('redis')->get('cloud.store');

        if(!count($validated))
        {
            throw new CommonException('ParamsIsNullError');
        }

        foreach ( $validated as $key => $value)
        {
            if(isset($value))
            {
                $systemVoiceConfig->$key = $value;
            }

        }

        $isUseCloudStore = Cache::store('redis')->get('cloud.store');

        //默认是本地存储
        $systemVoiceConfig->voice_save_type = 10;

        //如果启动了云存储,就是存储桶
        if($isUseCloudStore)
        {
            $systemVoiceConfig->voice_save_type = 20;
        }

        $systemVoiceConfig->admin_id = $admin->id;

        $systemVoiceConfig->created_time = time();
        $systemVoiceConfig->created_at = time();

        $systemVoiceConfigResult = $systemVoiceConfig->save();

        if(!$systemVoiceConfigResult)
        {
            throw new CommonException('AddSystemVoiceConfigError');
        }

        CommonEvent::dispatch($admin,$validated,'AddSystemVoiceConfig');

        $result = code(['code'=>0,'msg'=>'添加提示音配置成功']);

        return $result;
    }


    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function UpdateVoiceConfig($validated,$admin)
    {
        $result = code(config('admin_cdoe.UpdateSystemVoiceConfigError'));

        if(count($validated) == 0 || !isset($validated['id']))
        {
             throw new CommonException('ParamsIsNullError');
        }

        $systemVoiceConfig = SystemVoiceConfig::find($validated['id']);

        if(!$systemVoiceConfig)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$systemVoiceConfig ->revision];

        foreach ( $validated as $key => $value)
        {
            if($key === 'id')
            {
                $where[] = ['id','=',$value];
                continue;
            }

            if(isset($value))
            {
                $updateData[$key] = $value;
            }
        }

        $isUseCloudStore = Cache::store('redis')->get('cloud.store');

        //默认是本地存储
        $updateData['voice_save_type'] = 10;

        //如果启动了云存储,就是存储桶
        if($isUseCloudStore)
        {
            $updateData['voice_save_type'] = 20;
        }

        $updateData['admin_id'] = $admin->id;

        $updateData['revision'] = $systemVoiceConfig ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $systemVoiceConfigResult = $systemVoiceConfig::where($where)->update($updateData);

        if(!$systemVoiceConfigResult)
        {
           throw new CommonException('UpdateSystemVoiceConfigError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdateSystemVoiceConfig');

        $result = code(['code'=>0,'msg'=>'修改提示配置成功']);

        return $result;
    }


    /**
     * 删除
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function deleteVoiceConfig($validated,$admin)
    {
        //删除
        $result = code(config('admin_cdoe.DeleteSystemVoiceConfigError'));

        if(count($validated) == 0 || !isset($validated['id']))
        {
             throw new CommonException('ParamsIsNullError');
        }

        $systemVoiceConfig = SystemVoiceConfig::find($validated['id']);

        if(!$systemVoiceConfig)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $systemVoiceConfigResult =  $systemVoiceConfig->delete();

        if(!$systemVoiceConfigResult )
        {
            throw new CommonException('DeleteSystemVoiceConfigError');
        }

        CommonEvent::dispatch($admin,$validated,'DeleteSystemVoiceConfig');

        $result = code(['code'=>0,'msg'=>'删除提示配置成功']);

        return $result;
    }

    /**
     * 批量删除用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDeleteVoiceConfig($validated,$admin)
    {

        if(count($validated) == 0 || !isset($validated['selectId']) || count($validated['selectId']) == 0)
        {
            throw new CommonException('ParamsIsNullError');
        }

        $result = code(config('admin_cdoe.MultipleDeleteSystemVoiceConfigError'));

        $systemVoiceConfigResult = SystemVoiceConfig::whereIn('id',$validated['selectId'])->delete();


        if(!$systemVoiceConfigResult)
        {
            throw new CommonException('MultipleDeleteSystemVoiceConfigError');
        }

        CommonEvent::dispatch($admin,$validated,'MultipleDeleteSystemVoiceConfig');

        $result = code(['code'=>0,'msg'=>'批量删除提示配置成功']);

        return $result;
    }


}
