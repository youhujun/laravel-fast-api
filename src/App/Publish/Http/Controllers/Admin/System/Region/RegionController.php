<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 09:24:12
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 01:38:18
 * @FilePath: \app\Http\Controllers\Admin\System\Region\RegionController.php
 */


namespace App\Http\Controllers\Admin\System\Region;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Rules\Public\CheckArray;
use App\Rules\Public\CheckString;
use App\Rules\Public\ChineseCodeNumberLine;
use App\Rules\Public\Numeric;
use App\Rules\Public\Required;
use App\Rules\Public\CheckBetween;
use App\Rules\Public\CheckUnique;
use App\Rules\Public\LetterNumberUnderLine;

use App\Rules\Admin\Common\TreeDeep;

use App\Facade\Admin\System\Region\AdminRegionFacade;

class RegionController extends Controller
{
    /**
     * 获取所有地址
     *
     * @return void
     */
    public function getAllRegion()
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
             $result = AdminRegionFacade::getAllRegion();
        }

        return $result;
    }

    /**
     * 获取树形地址
     *
     * @return void
     */
    public function getTreeRegion()
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
             $result = AdminRegionFacade::getTreeRegion();
        }

        return $result;
    }


     /**
     * 添加顶级/下级地区
     *
     * @param Request $request
     * @return void
     */
    public function addRegion(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'parent_id'=>['bail',new Required,new Numeric],
                    'deep' => ['bail',new Required,new TreeDeep],
                    'sort' => ['bail',new Required,new Numeric],
                    'region_name'=>['bail',new Required,new CheckString,new CheckBetween(2,30),new ChineseCodeNumberLine],
                ],[]);

            $validated = $validator->validated();

            $result = AdminRegionFacade::addRegion(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 修改地区
     *
     * @param Request $request
     * @return void
     */
    public function updateRegion(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'parent_id'=>['bail',new Required,new Numeric],
                    'deep' => ['bail',new Required,new TreeDeep],
                    'sort' => ['bail',new Required,new Numeric],
                    'region_name'=>['bail',new Required,new CheckString,new CheckBetween(2,10),new ChineseCodeNumberLine],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminRegionFacade::updateRegion(f($validated),$admin);
        }
        return $result;
    }

    /**
     * 树形控件移动
     *
     * @param Request $request
     * @return void
     */
    public function moveRegion(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'parent_id'=>['bail',new Required,new Numeric],
                    'dropType' => ['bail',new Required,new TreeDeep],
                    'sort' => ['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminRegionFacade::moveRegion($validated,$admin);
        }

       return $result;
    }

    /**
     * 删除地区
     *
     * @param Request $request
     * @return void
     */
    public function deleteRegion(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminRegionFacade::deleteRegion(f($validated),$admin);

        }

        return $result;
    }
}
