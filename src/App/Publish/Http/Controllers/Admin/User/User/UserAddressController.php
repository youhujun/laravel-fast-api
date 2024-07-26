<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-11 15:08:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 15:39:20
 * @FilePath: \app\Http\Controllers\Admin\User\User\UserAddressController.php
 */

namespace App\Http\Controllers\Admin\User\User;

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

use App\Facade\Admin\User\User\AdminUserAddressFacade;

class UserAddressController extends Controller
{

    /**
     * 添加用户地址
     *
     * @param Request $request
     * @return void
     */
    public function addUserAddress(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'user_id'=>['bail',new Required,new Numeric],
                    'is_default'=>['bail',new Required,new Numeric],
                    'address_type'=>['bail',new Required,new Numeric],
                    'regionArray'=>['bail',new Required,new CheckArray],
                    'address_info'=>['bail',new Required,new CheckString,new CheckBetween(1,128),new ChineseCodeNumberLine],
                ],
                []
            );

            $validated = $validator->validated();

            // p($validated);die;

            $result =  AdminUserAddressFacade::addUserAddress(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 获取用户地址
     *
     * @param Request $request
     * @return void
     */
    public function getUserAddress(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id'=>['bail',new Required,new Numeric],
                    // 当前页
                    'currentPage' => ['bail', 'nullable', new Numeric],
                    // 每页条数
                    'pageSize' => ['bail', 'nullable', new Numeric],
                    // 排序类型
                    'sortType' => ['bail', new Required, new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result =  AdminUserAddressFacade::getUserAddress(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 删除用户地址
     *
     * @param Request $request
     * @return void
     */
    public function deleteUserAddress(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_address_id'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result =  AdminUserAddressFacade::deleteUserAddress(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 设置用户默认地址
     *
     * @param Request $request
     * @return void
     */
    public function setDefaultUserAddress(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_address_id'=>['bail',new Required,new Numeric],
                    'user_id'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result =  AdminUserAddressFacade::setDefaultUserAddress(f($validated),$admin);
        }

        return $result;
    }
}
