<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-16 16:53:56
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 22:59:00
 * @FilePath: \app\Http\Controllers\Admin\System\Level\LevelItemController.php
 */

namespace App\Http\Controllers\Admin\System\Level;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

use App\Rules\Public\CheckArray;
use App\Rules\Public\CheckBetween;
use App\Rules\Public\CheckString;
use App\Rules\Public\CheckUnique;
use App\Rules\Public\ChineseCodeNumberLine;
use App\Rules\Public\Numeric;
use App\Rules\Public\Required;

use \App\Facade\Admin\System\Level\AdminLevelItemFacade;

class LevelItemController extends Controller
{
     /**
     * 获取默认级别条件列表
     */
    public function defaultLevelItem(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'type'=>['bail','nullable',new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result =  AdminLevelItemFacade::defaultLevelItem($validated);
        }

        return $result;
    }

    /**
     * 查找级别条件列表
     *
     * @param Request $request
     * @return void
     */
    public function findLevelItem(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'find'=>['bail',new Required],
                    'type'=>['bail','nullable',new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminLevelItemFacade::findLevelItem(f($validated));
        }

        return $result;
    }


    /**
     * 获取级别条件列表
     */
    public function getLevelItem(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

       $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'find'=>['bail','nullable',new CheckString],
                    'findSelectIndex'=>['bail','nullable',new Numeric],
                    'timeRange'=>['bail','nullable',new CheckArray],
                    'sortType'=>['bail',new Required,new Numeric],
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminLevelItemFacade::getLevelItem(f($validated));
        }

        return $result;
    }

    /**
     * 添加级别条件
     *
     * @param Request $request
     * @return void
     */
    public function addLevelItem(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'sort'=>['bail',new Required,new Numeric],
                    'type'=>['bail',new Required,new Numeric],
                    'item_name'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('level_item','item_name')],
                    'item_code'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('level_item','item_code')],
                    'description'=>['bail','nullable',new CheckString,new CheckBetween(1,30)],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminLevelItemFacade::addLevelItem(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 修改级别条件
     *
     * @param Request $request
     * @return void
     */
    public function updateLevelItem(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $id = checkId($request->input('id'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'sort'=>['bail',new Required,new Numeric],
                    'type'=>['bail',new Required,new Numeric],
                    'item_name'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('level_item','item_name',$id)],
                    'item_code'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('level_item','item_code',$id)],
                    'description'=>['bail','nullable',new CheckString,new CheckBetween(1,30)],

                ],
                []
            );

           $validated = $validator->validated();

           $result =AdminLevelItemFacade::updateLevelItem(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 删除级别条件
     *
     * @param Request $request
     * @return void
     */
    public function deleteLevelItem(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminLevelItemFacade::deleteLevelItem($validated,$admin);
        }

        return $result;
    }

    /**
     * 批量删除级别条件
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteLevelItem(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'selectId'=>['bail',new Required,new CheckArray],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminLevelItemFacade::multipleDeleteLevelItem(f($validated),$admin);
        }

        return $result;
    }

}
