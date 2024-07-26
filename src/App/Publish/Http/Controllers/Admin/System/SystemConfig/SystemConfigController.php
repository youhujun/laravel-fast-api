<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 23:59:56
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-06 21:54:26
 * @FilePath: \app\Http\Controllers\Admin\System\SystemConfig\SystemConfigController.php
 */

namespace App\Http\Controllers\Admin\System\SystemConfig;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Rules\Public\Required;
use App\Rules\Public\Numeric;
use App\Rules\Public\CheckString;
use App\Rules\Public\CheckBetween;
use App\Rules\Public\CheckArray;
use App\Rules\Public\FormatTime;
use App\Rules\Public\CheckUnique;
use App\Rules\Public\ChineseCodeNumberLine;

use App\Rules\Admin\System\System\SystemConfigItemType;

use App\Facade\Admin\System\SystemConfig\AdminSystemConfigFacade;


class SystemConfigController extends Controller
{
	 /**
     * 获取默认选项
     */
    public function defaultSystemConfig(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('phone_token')->user();

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

            $result =  AdminSystemConfigFacade::defaultSystemConfig(f($validated));
        }

        return $result;
    }

    /**
     * 查找选项
     *
     * @param Request $request
     * @return void
     */
    public function findSystemConfig(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));
        $result = code(\config('phone_code.PhoneAuthError'));

        $admin = Auth::guard('phone_token')->user();
        $user = Auth::guard('phone_token')->user();

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

            $result = AdminSystemConfigFacade::findSystemConfig(f($validated));
        }

        return $result;
    }


    /**
     * 查询
     */
    public function getSystemConfig(Request $request)
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
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric],
                    'sortType'=>['bail',new Required,new Numeric],
                    'item_type'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminSystemConfigFacade::getSystemConfig(f($validated));
        }

        return $result;
    }

    /**
     * 添加
     *
     * @param Request $request
     * @return void
     */
    public function addSystemConfig(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'item_type'=>[new Required,new Numeric,new SystemConfigItemType],
                    'item_label'=>['bail','nullable',new CheckString,new CheckBetween(2,50)],
                    'item_price'=>['bail','nullable',new Numeric],
                    'item_value'=>['bail','nullable',new CheckString,new CheckBetween(2,128)],
                    'item_path'=>['bail','nullable',new CheckString,new CheckBetween(2,128)],
                    'item_introduction'=>['bail','nullable',new CheckString,new CheckBetween(2,50)],
                    'sort' => ['bail','nullable',new Numeric],
                ],
                [ ]
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminSystemConfigFacade::addSystemConfig(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 修改
     *
     * @param Request $request
     * @return void
     */
    public function updateSystemConfig(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                    $request->all(),
                    [
                        'id'=>['bail',new Required,new Numeric],
                        'item_type'=>[new Required,new Numeric,new SystemConfigItemType],
                        'item_label'=>['bail','nullable',new CheckString,new CheckBetween(2,50)],
                        'item_price'=>['bail','nullable',new Numeric],
                        'item_value'=>['bail','nullable',new CheckString,new CheckBetween(2,128)],
                        'item_path'=>['bail','nullable',new CheckString,new CheckBetween(2,128)],
                        'item_introduction'=>['bail','nullable',new CheckString,new CheckBetween(2,50)],
                        'sort' => ['bail','nullable',new Numeric],
                    ],
                    [ ]
            );

           $validated = $validator->validated();

           //p($validated);die;

           $result =AdminSystemConfigFacade::updateSystemConfig(f($validated),$admin);
        }

        return $result;
    }


    /**
     * 删除
     *
     * @param Request $request
     * @return void
     */
    public function deleteSystemConfig(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                ],
                [ ]
            );

            $validated = $validator->validated();

            $result = AdminSystemConfigFacade::deleteSystemConfig(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 批量删除
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteSystemConfig(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'selectId'=>['bail',new Required,new CheckArray],
                ],
                [ ]
            );

            $validated = $validator->validated();

            $result = AdminSystemConfigFacade::multipleDeleteSystemConfig(f($validated),$admin);
        }

        return $result;
    }

}
