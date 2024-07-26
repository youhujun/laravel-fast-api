<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-17 10:21:04
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-27 22:30:44
 * @FilePath: \app\Http\Controllers\Admin\System\Level\UserLevelController.php
 */

namespace App\Http\Controllers\Admin\System\Level;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Rules\Public\CheckArray;
use App\Rules\Public\CheckString;
use App\Rules\Public\ChineseCodeNumberLine;
use App\Rules\Public\Numeric;
use App\Rules\Public\Required;
use App\Rules\Public\CheckBetween;
use App\Rules\Public\CheckUnique;

use App\Facade\Admin\System\Level\AdminUserLevelFacade;

class UserLevelController extends Controller
{
    /**
     * 获取默认选项
     */
    public function defaultUserLevel(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $user = Auth::guard('admin_token')->user();

        if(Gate::forUser($user)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'type'=>['bail','nullable',new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result =  AdminUserLevelFacade::defaultUserLevel($validated);
        }

        return $result;
    }

    /**
     * 查找选项
     *
     * @param Request $request
     * @return void
     */
    public function findUserLevel(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        if(Gate::forUser($user)->allows('admin-role'))
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

            $result = AdminUserLevelFacade::findUserLevel(f($validated));
        }

        return $result;
    }


    /**
     * 获取用户级别列表
     */
    public function getUserLevel(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

       $user = Auth::guard('admin_token')->user();

        if(Gate::forUser($user)->allows('admin-role'))
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

            $result = AdminUserLevelFacade::getUserLevel(f($validated));
        }

        return $result;
    }

    /**
     * 添加用户级别列表
     *
     * @param Request $request
     * @return void
     */
    public function addUserLevel(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $user = Auth::guard('admin_token')->user();

        if(Gate::forUser($user)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'sort'=>['bail',new Required,new Numeric],
                    'level_name'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('user_level','level_name')],
                    'level_code'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('user_level','level_code')],
                    'amount'=>['bail','nullable',new Numeric],
                    'background_id'=>['bail','nullable',new Numeric],
                    'remark_info'=>['bail','nullable',new CheckString,new CheckBetween(1,60)],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminUserLevelFacade::addUserLevel(f($validated),$user);
        }

        return $result;
    }

    /**
     * 修改用户级别列表
     *
     * @param Request $request
     * @return void
     */
    public function updateUserLevel(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $id = checkId($request->input('id'));

        if(Gate::forUser($user)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'sort'=>['bail',new Required,new Numeric],
                    'level_name'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('user_level','level_name',$id)],
                    'level_code'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('user_level','level_code',$id)],
                    'amount'=>['bail','nullable',new Numeric],
                    'background_id'=>['bail','nullable',new Numeric],
                    'remark_info'=>['bail','nullable',new CheckString,new CheckBetween(1,60)],
                ],
                []
            );

           $validated = $validator->validated();

           $result =AdminUserLevelFacade::updateUserLevel(f($validated),$user);
        }

        return $result;
    }

    /**
     * 删除用户级别列表
     *
     * @param Request $request
     * @return void
     */
    public function deleteUserLevel(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminUserLevelFacade::deleteUserLevel($validated,$user);
        }

        return $result;
    }

    /**
     * 批量删除用户级别列表
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteUserLevel(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'selectId'=>['bail',new Required,new CheckArray],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminUserLevelFacade::multipleDeleteUserLevel(f($validated),$user);
        }

        return $result;
    }


    /**
     * 添加用户级别配置项值
     *
     * @param Request $request
     * @return void
     */
    public function addUserLevelItemUnion(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $user = Auth::guard('admin_token')->user();

        if(Gate::forUser($user)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'sort'=>['bail',new Required,new Numeric],
                    'user_level_id'=>['bail',new Required,new Numeric],
                    'level_item_id'=>['bail',new Required,new Numeric],
                    'value'=>['bail',new Required,new Numeric],
                    'value_type'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            if(isset($validated['id']) && $validated['id'] === 0)
            {
                unset($validated['id']);
            }

            $result = AdminUserLevelFacade::addUserLevelItemUnion(f($validated),$user);
        }

        return $result;
    }

    /**
     * 修改
     *
     * @param Request $request
     * @return void
     */
    public function updateUserLevelItemUnion(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'sort'=>['bail',new Required,new Numeric],
                    'user_level_id'=>['bail',new Required,new Numeric],
                    'level_item_id'=>['bail',new Required,new Numeric],
                    'value'=>['bail',new Required,new Numeric],
                    'value_type'=>['bail',new Required,new Numeric]
                ],
                []
            );

           $validated = $validator->validated();

           $result =AdminUserLevelFacade::updateUserLevelItemUnion(f($validated),$user);
        }

        return $result;
    }

    /**
     * 删除
     *
     * @param Request $request
     * @return void
     */
    public function deleteUserLevelItemUnion(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminUserLevelFacade::deleteUserLevelItemUnion($validated,$user);
        }

        return $result;
    }

}
