<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 23:43:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-19 16:22:27
 * @FilePath: \app\Service\Facade\Admin\System\SystemConfig\AdminSystemConfigFacadeService.php
 */

namespace App\Service\Facade\Admin\System\SystemConfig;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Service\Facade\Trait\QueryService;

use App\Facade\Common\Excel;

use App\Models\System\SystemConfig;

use  App\Http\Resources\Admin\System\System\SystemConfigResource;
use App\Http\Resources\Admin\System\System\SystemConfigCollection;


/**
 * @see \App\Facade\Admin\System\SystemConfig\AdminSystemConfigFacade
 */
class AdminSystemConfigFacadeService
{
   public function test()
   {
       echo "AdminSystemConfigFacadeService test";
   }

   use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

   protected static $searchItem = [
        'item_label',
        'item_introduction'
    ];

   protected static $storage_public_path = DIRECTORY_SEPARATOR.'app'. DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR;


    /**
     * 查询
     *
     * @param [type] $validated
     * @return void
     */
    public function getSystemConfig($validated)
    {

       $result = code(config('admin_cdoe.GetSystemConfigError'));

       $this->setQueryOptions($validated);

       $query =SystemConfig::where([]);

       //是否删除
       if(isset($validated['is_delete']) && $validated['is_delete'])
       {
            $query->onlyTrashed();
       }

       if(isset($validated['findSelectIndex']))
       {
            if(isset($validated['find']) && !empty($validated['find']))
            {
               $this->where[] = [self::$searchItem[$validated['findSelectIndex']],'like',"%{$validated['find']}%"];

               $query =SystemConfig::where($this->where);
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

        $systemConfigList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(\optional($systemConfigList))
        {
            $result = new SystemConfigCollection($systemConfigList,['code'=>0,'msg'=>'获取系统配置成功!'],$download);
            //如果要增加其他返回参数,需要在SystemConfigCollection处理
            //$result = code(config('admin_cdoe.replaceSuccess'),['data'=>$systemConfigList,'download' => $download]);
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
    public function addSystemConfig($validated,$admin)
    {
        $result = code(config('admin_cdoe.AddSystemConfigError'));

        $systemConfig = new SystemConfig;

        foreach ( $validated as $key => $value)
        {
            if(isset($value))
            {
                $systemConfig->$key = $value;
            }
        }

        $systemConfig->created_time = time();
        $systemConfig->created_at = time();

        $systemConfigResult = $systemConfig->save();

        if(!$systemConfigResult)
        {
             throw new CommonException('AddSystemConfigError');
        }

        $eventResult = CommonEvent::dispatch($admin,$systemConfig,'AddSystemConfig');

        Redis::hdel('system:config','listSystemConfig');
        Redis::hdel('system:config','isSetSystemConfig');
        Cache::store('redis')->flush();

        $result = code(['code'=>0,'msg'=>'添加系统配置成功!']);

        return $result;
    }


    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updateSystemConfig($validated,$admin)
    {
        $result = code(config('admin_cdoe.UpdateSystemConfigError'));

        $systemConfig = SystemConfig::find($validated['id']);

        if(!optional($systemConfig))
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$systemConfig ->revision];

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

        $updateData['revision'] = $systemConfig ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $systemConfigResult = SystemConfig::where($where)->update($updateData);

        if(!$systemConfigResult)
        {
           throw new CommonException('UpdateSystemConfigError');
        }

        $eventResult = CommonEvent::dispatch($admin,$systemConfig,'UpdateSystemConfig');

        Redis::hdel('system:config','listSystemConfig');
        Redis::hdel('system:config','isSetSystemConfig');
        Cache::store('redis')->flush();

        $result = code(['code'=>0,'msg'=>'更新系统配置成功']);

        return $result;
    }


    /**
     * 删除
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function deleteSystemConfig($validated,$admin)
    {
        //删除
        $result = code(config('admin_cdoe.DeleteSystemConfigError'));

        $eventName = 'DeleteSystemConfig';

        $systemConfig = SystemConfig::find($validated['id']);

        if(!optional($systemConfig))
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $systemConfigResult =  $systemConfig->delete();

        if(!$systemConfigResult )
        {
            throw new CommonException('DeleteSystemConfigError');
        }

        $eventResult = CommonEvent::dispatch($admin,$validated['id'],$eventName);

        Redis::hdel('system:config','listSystemConfig');
        Redis::hdel('system:config','isSetSystemConfig');
        Cache::store('redis')->flush();

        $result = code(['code'=>0,'msg'=>'删除成功']);

        return $result;
    }

    /**
     * 批量删除用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDeleteSystemConfig($validated,$admin)
    {

        $result = code(config('admin_cdoe.MultipleDeleteSystemConfigError'));

        $eventName = 'MultipleDeleteSystemConfig';

        $deleteResult = SystemConfig::whereIn('id',$validated['selectId'])->delete();

        if(!$deleteResult)
        {
            throw new CommonException('MultipleRestoreSystemConfigError');
        }

        $eventResult = CommonEvent::dispatch($admin,$validated,$eventName);

        Redis::hdel('system:config','listSystemConfig');
        Redis::hdel('system:config','isSetSystemConfig');
        Cache::store('redis')->flush();

        $result = code(['code'=>0,'msg'=>'批量删除成功']);

        return $result;
    }

}
