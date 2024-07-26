<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-31 23:22:53
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 01:02:47
 * @FilePath: \app\Service\Facade\Admin\System\Region\AdminRegionFacadeService.php
 */

namespace App\Service\Facade\Admin\System\Region;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Service\Facade\Trait\AlwaysService;

use App\Exceptions\Admin\CommonException;

use App\Events\Admin\CommonEvent;

use App\Models\System\Region\Region;
use App\Models\User\UserAddress;

use App\Http\Resources\System\RegionResource;

/**
 * @see \App\Facade\Admin\System\Region\AdminRegionFacade
 */
class AdminRegionFacadeService
{
   public function test()
   {
       echo "AdminRegionFacadeService test";
   }

   use AlwaysService;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->init((new Region),'deep');
    }

    /**
     * 结合redis获取所有地区
     *
     * @return void
     */
    public function getAllRegion()
    {
        $result = code(config('admin_code.GetAllRegionError'));

        $redisAllRegion = Redis::hget('system:config','allRegions');

        if($redisAllRegion)
        {
            $allRegion = \json_decode($redisAllRegion,true);
        }
        else
        {
            $allRegion = $this->getAllData();

            $redisResult = Redis::hset('system:config','allRegions',json_encode($allRegion));
        }

        RegionResource::showControl(1);

        $data['data'] = RegionResource::collection($allRegion);

        $result = code(['code'=>0,'msg'=>'获取所有地区成功!'],$data);

        return  $result;

    }

    /**
     * 结合redis获取所有树形地区
     *
     * @return void
     */
    public function getTreeRegion()
    {
        $result = code(config('admin_code.GetTreeRegionError'));

        $redisTreeRegion = Redis::hget('system:config','treeRegions');

        if($redisTreeRegion)
        {
            $treeRegion = \json_decode($redisTreeRegion,true);
        }
        else
        {
            $treeRegion = $this->getTreeData();

            $redisResult = Redis::hset('system:config','treeRegions',convertToString($treeRegion));
        }

        RegionResource::showControl(1);

        $data['data'] = RegionResource::collection($treeRegion);

        $result = code(['code'=>0,'msg'=>'获取树形地区成功!'],$data);

        return  $result;
    }

    /**
     *  添加地区
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function addRegion($validated,$admin)
    {
        $result = code(config('admin_code.AddRegionError'));

        $region = new Region;

        foreach ( $validated as $key => $value)
        {
            if(\is_null($value))
            {
                $value = "";
            }

            $region->$key = $value;
        }

        $region->created_time = time();
        $region->created_at = time();

        $regionResult = $region->save();

        if(!$regionResult )
        {
            throw new CommonException('AddRegionError');
        }

        CommonEvent::dispatch($admin,$validated,'AddRegion');

        //清除缓存
        Redis::hdel('system:config','allRegions');
        Redis::hdel('system:config','treeRegions');

        $result = code(['code'=>0,'msg'=>'添加地区成功!']);

        return $result;
    }

    /**
     * 更新地区
     *
     * @param [type] $validated
     * @param [type] $user
     * @return void
     */
    public function updateRegion($validated,$admin)
    {
        $result = code(config('admin_code.UpdateRegionError'));

        $region = Region::find($validated['id']);

        if(!$region)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $where = [];
        $updateData = [];

        $where[] = ['revision','=',$region->revision];

        foreach ( $validated as $key => $value)
        {
            if($key === 'id')
            {
                \array_push($where,['id','=',$value]);
                continue;
            }

            if(\is_null($value))
            {
                $value = "";
            }

            $updateData[$key] = $value;
        }

        $updateData['updated_time'] = time();
        $updateData['updated_at']  = date('Y-m-d H:i:s',time());
        $updateData['revision']  = $region->revision + 1;


        $regionResult = Region::where($where)->update($updateData);

        if(!$regionResult)
        {
            throw new CommonException('UpdateRegionError');
        }

        CommonEvent::dispatch($admin,$validated,'UpdateRegion');


        //清除缓存
        Redis::hdel('system:config','allRegions');
        Redis::hdel('system:config','treeRegions');

        $result = code(['code'=>0,'msg'=>'更新地区成功!']);

        return $result;
    }

    /**
     * 更新
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function moveRegion($validated,$admin)
    {
        $result = code(config('admin_code.MoveRegionError'));

        $region = Region::find($validated['id']);

        if(!$region)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $regionRevision = $region->revision;

        $oldDeep = $region->deep;

        $parentDeep = 1;

        if($validated['parent_id'])
        {
             $parentRegion = Region::find($validated['parent_id']);

             $parentDeep = $parentRegion->deep + 1;
        }


        if(self::$dropType[$validated['dropType']] == 10)
        {
           $regionUpdate = [
                'updated_time'=>time(),
                'updated_at'=>date('Y-m-d H:i:s',time()),
                'parent_id' => $validated['parent_id'],
                'deep' => $parentDeep,
                'revision'=>$regionRevision + 1
            ];
        }

        if(self::$dropType[$validated['dropType']] == 20)
        {
           $regionUpdate = [
                'updated_time'=>time(),
                'updated_at'=>date('Y-m-d H:i:s',time()),
                'parent_id' => $validated['parent_id'],
                'sort'=> $validated['sort'],
                'deep'=> $parentDeep,
                'revision'=>$regionRevision + 1
            ];
        }

        if(self::$dropType[$validated['dropType']] == 30)
        {
           $regionUpdate = [
                'updated_time'=>time(),
                'updated_at'=>date('Y-m-d H:i:s',time()),
                'parent_id' => $validated['parent_id'],
                'sort'=> $validated['sort'],
                'deep'=> $parentDeep,
                'revision'=>$regionRevision + 1
            ];
        }

       $regionWhere = [['id','=',$validated['id']],['revision','=',$regionRevision]];

        //更新配置项
       $regionResult =Region::where($regionWhere)->update($regionUpdate);

        if(!$regionResult)
        {
            throw new CommonException('MoveRegionError');
        }

        CommonEvent::dispatch($admin,$validated,'MoveRegion');

        //修改子级deep
        $deepNumber = $parentDeep - $oldDeep;

        $updateDeepResult = $this->updateChildrenDeep($region->id,$deepNumber);

        //清空redis的缓存数据
        $redisAllRegionResult = Redis::hdel('system:config','allRegions');
        $redisTreeRegionResult = Redis::hdel('system:config','treeRegions');

        $result = code(['code'=>0,'msg'=>'移动地区成功!']);

        return $result;
    }

    /**
     * 删除地区
     *
     * @param [type] $id
     * @param [type] $user
     * @return void
     */
    public function deleteRegion($validated,$admin)
    {
        $result = code(config('admin_code.DeleteRegionError'));

        $id = $validated['id'];
        //查看是否有子类
        $region = Region::where('parent_id',$id)->get();


        $count = $region->count();

        if($count)
        {
            throw new CommonException('DeleteNoRegionError');
        }

        //查看是否有用户具有该地区
        $countryRegion = UserAddress::where('country_id',$id)->get()->count();
        $provinceRegion = UserAddress::where('province_id',$id)->get()->count();
        $regionRegion = UserAddress::where('region_id',$id)->get()->count();
        $cityRegion = UserAddress::where('city_id',$id)->get()->count();
        $townsRegion = UserAddress::where('towns_id',$id)->get()->count();
        $villageRegion = UserAddress::where('village_id',$id)->get()->count();

        if($countryRegion || $provinceRegion || $regionRegion || $cityRegion || $townsRegion || $villageRegion)
        {
            throw new CommonException('DeleteNoUserRegionError');
        }

        $delRegion = Region::find($id);

        if(!$delRegion)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $delRegion->deleted_time = time();

        $delRegion->deleted_at = time();

        $delRegionResult =  $delRegion->save();

        if(!$delRegionResult)
        {
            throw new CommonException('DeleteRegionError');
        }

        CommonEvent::dispatch($admin,$validated,'DeleteRegion');

        //清除缓存
        Redis::hdel('system:config','allRegions');
        Redis::hdel('system:config','treeRegions');

        $result = code(['code'=>0,'msg'=>'删除地区成功!']);

        return $result;
    }
}
