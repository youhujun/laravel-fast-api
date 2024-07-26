<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 22:32:30
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-26 19:11:36
 * @FilePath: d:\wwwroot\Working\YouHu\Componenets\Laravel\youhujun\laravel-fast-api\src\App\Publish\Service\Facade\Admin\System\Level\AdminLevelItemFacadeService.php
 */

namespace App\Service\Facade\Admin\System\Level;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Service\Facade\Trait\QueryService;

use App\Models\System\Level\LevelItem;

use App\Models\Log\UploadFileLog;

use App\Http\Resources\System\Level\LevelItemResource;
use App\Http\Resources\System\Level\LevelItemCollection;

/**
 * @see \App\Facade\Admin\System\Level\AdminLevelItemFacade
 */
class AdminLevelItemFacadeService
{
   public function test()
   {
       echo "AdminLevelItemFacadeService test";
   }

   use QueryService;

   protected static $sort = [
      1 => ['created_time','asc'],
      2 => ['created_time','desc'],
    ];

   protected static $searchItem = [
        'item_name',
        'item_code'
    ];

   protected static $storage_public_path = DIRECTORY_SEPARATOR.'app'. DIRECTORY_SEPARATOR.'public';

    /**
     * 获取常用
     *
     * @param [type] $user
     * @return void
     */
    public function defaultLevelItem()
    {
        $result = code(config('admin_code.DefaultlevelItemError'));

        $this->where = [];

        $levelItemList = LevelItem::where($this->where)->orderBy('sort','desc')->orderBy('created_at','asc')->get();

        if(!optional($levelItemList))
        {
            throw new CommonException('DefaultlevelItemError');
        }

		$result = new LevelItemCollection($levelItemList,['code'=>0,'msg'=>'获取默认级别配置项成功!']);

        return  $result;

    }

    /**
     * 搜索查找选项
     *
     * @param [type] $find
     * @return void
     */
    public function findLevelItem($validated)
    {
        $result = code(config('admin_code.FindlevelItemError'));

        $this->where[] = ['item_name','like',"%{$validated['find']}%"];

        $levelItemList = LevelItem::where($this->where)->orderBy('sort','desc')->orderBy('created_at','asc')->get();

        if(!optional($levelItemList))
        {
            throw new CommonException('FindlevelItemError');
        }

		$result = new LevelItemCollection($levelItemList,['code'=>0,'msg'=>'查找级别配置项成功!']);

        return  $result;
    }

    /**
     * 查询
     *
     * @param [type] $validated
     * @return void
     */
    public function getLevelItem($validated)
    {

       $result = code(config('admin_code.GetLevelItemError'));

       $this->setQueryOptions($validated);

       $query =LevelItem::where([]);

       if(isset($validated['findSelectIndex']))
       {
            if(isset($validated['find']) && !empty($validated['find']))
            {
               $this->where[] = [self::$searchItem[$validated['findSelectIndex']],'like',"%{$validated['find']}%"];

               $query =LevelItem::where($this->where);
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


        $levelItemList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(\optional($levelItemList))
        {
			$result = new LevelItemCollection( $levelItemList,['code'=>0,'msg'=>'获取级别配置项成功!']);
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
    public function addLevelItem($validated,$admin)
    {

        $result = code(config('admin_code.AddLevelItemError'));

        $levelItem = new LevelItem;

        foreach ( $validated as $key => $value)
        {
            if(\is_null($value))
            {
                $value = "";
            }

            $levelItem->$key = $value;
        }

        $levelItem->created_time = time();
        $levelItem->created_at = time();

        $levelItemResult = $levelItem->save();

        if(!$levelItemResult)
        {
            throw new CommonException('AddLevelItemError');
        }

        CommonEvent::dispatch($admin,$levelItem,'AddLevelItem');

        $result = code(['code'=>0,'msg'=>'添加级别配置项成功!']);

        return $result;
    }


    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updateLevelItem($validated,$admin)
    {
        $result = code(config('admin_code.UpdateLevelItemError'));

        $levelItem = LevelItem::find($validated['id']);
		
		if(!$levelItem)
		{
			throw new CommonException('ThisDataNotExistsError');
		}

        $where = [];

        $updateData = [];

        $where[] = ['revision','=',$levelItem ->revision];

        foreach ( $validated as $key => $value)
        {
            if($key === 'id')
            {
                $where[] = ['id','=',$value];
                continue;
            }

            if(\is_null($value))
            {
                $value = "";
            }

            $updateData[$key] = $value;
        }

        $updateData['revision'] = $levelItem ->revision + 1;

        $updateData['updated_time'] = time();

        $updateData['updated_at']  = date('Y-m-d H:i:s',time());

        $levelItemResult = LevelItem::where($where)->update($updateData);

        if(!$levelItemResult)
        {
           throw new CommonException('UpdateLevelItemError');
        }

        CommonEvent::dispatch($admin,$levelItem,'UpdateLevelItem');

        $result = code(['code'=>0,'msg'=>'更改级别配置项成功!']);

        return $result;
    }


    /**
     * 删除
     *
     * @param [type] $id
     * @param [type] $admin
     * @return void
     */
    public function deleteLevelItem($validated,$admin)
    {
        $result = code(config('admin_code.DeleteLevelItemError'));

        $levelItem = LevelItem::find($validated['id']);

        $levelItem->deleted_time = time();

        $levelItem->deleted_at = showTime(time(),true);

        $levelItemResult =  $levelItem->save();

        if(!$levelItemResult )
        {
            throw new CommonException('DeleteLevelItemError');
        }

        CommonEvent::dispatch($admin,$validated['id'],'DeleteLevelItem');

        $result = code(['code'=>0,'msg'=>'删除级别配置项成功!']);

        return $result;
    }

    /**
     * 批量删除用户
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDeleteLevelItem($validated,$admin)
    {
        $result = code(config('admin_code.MultipleDeleteLevelItemError'));

        if(isset($validated['selectId']) && count($validated['selectId']))
        {

            $deleteResult = LevelItem::whereIn('id',$validated['selectId'])->delete();

            if(!$deleteResult)
            {
                throw new CommonException('MultipleDeleteLevelItemError');
            }

            CommonEvent::dispatch($admin,$validated,'MultipleDeleteLevelItem');

            $result = code(['code'=>0,'msg'=>'批量删除级别配置项成功!']);
        }

        return $result;
    }
}
