<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-14 09:09:59
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-11 14:40:39
 * @FilePath: \api.laravel.com_LV9\app\Http\Controllers\Admin\User\User\UserDetailsController.php
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

use App\Rules\Admin\User\User\CheckSex;
use App\Rules\Common\IdNumber;

use App\Facade\Admin\User\User\AdminUserDetailsFacade;


class UserDetailsController extends Controller
{

    /**
     * 修改用户手机号
     *
     * @param Request $request
     * @return void
     */
    public function updateUserPhone(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        $id = $request->input('user_id');

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id'=>['bail',new Required,new Numeric],
                    'phone'=>['bail',new Required,new CheckUnique('users','phone',$id)],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated); die;

            $result =  AdminUserDetailsFacade::updateUserPhone(f($validated),$admin);
        }

        return $result;
    }

     /**
     * 修改用户真实姓名
     *
     * @param Request $request
     * @return void
     */
    public function updateUserRealName(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id'=>['bail',new Required,new Numeric],
                    'real_name'=>['bail', 'nullable', new CheckString, new CheckBetween(2, 10), new ChineseCodeNumberLine],
                ],
                []
            );

            $validated = $validator->validated();

            $result =  AdminUserDetailsFacade::updateUserRealName(f($validated),$admin);
        }

        return $result;
    }

     /**
     * 修改用户昵称
     *
     * @param Request $request
     * @return void
     */
    public function updateUserNickName(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id'=>['bail',new Required,new Numeric],
                    'nick_name'=> ['bail', 'nullable', new CheckString, new CheckBetween(1, 60)],
                ],
                []
            );

            $validated = $validator->validated();

            $result =  AdminUserDetailsFacade::updateUserNickName(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 修改用户性别
     *
     * @param Request $request
     * @return void
     */
    public function updateUserSex(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id'=>['bail',new Required,new Numeric],
                    'sex'=>['bail', 'nullable', new Numeric, new CheckSex],
                ],
                []
            );

            $validated = $validator->validated();

            $result =  AdminUserDetailsFacade::updateUserSex(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 更改用户级别
     *
     * @param Request $request
     * @return void
     */
    public function changeUserLevel(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('admin-role')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'id' => ['bail', new Required, new Numeric],
                    'level_id' => ['bail', new Required, new Numeric],

                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminUserDetailsFacade::changeUserLevel($validated, $admin);
        }

        return $result;
    }




    /**
     * 修改用户生日
     *
     * @param Request $request
     * @return void
     */
    public function updateUserBirthdayTime(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id'=>['bail',new Required,new Numeric],
                    'solar_birthday_time' => ['bail', 'nullable', new CheckString, new FormatTime],
                ],
                []
            );

            $validated = $validator->validated();

            $result =  AdminUserDetailsFacade::updateUserBirthdayTime(f($validated),$admin);
        }
        return $result;
    }

    /**
     * 重置用户密码
     *
     * @return void
     */
    public function resetUserPassword(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id'=>['bail',new Required,new Numeric],
                    'password' => ['bail', 'nullable', new CheckString,new CheckBetween(6,10)],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result =  AdminUserDetailsFacade::resetUserPassword(f($validated),$admin);
        }

        return $result;
    }

     /**
     *获取用户二维码
     */
    public function getUserQrcode(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('admin-role')) {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => ['bail', new Required, new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminUserDetailsFacade::getUserQrcode($validated, $admin);
        }

        return $result;
    }



}
