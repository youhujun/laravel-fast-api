<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-11 15:32:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 17:18:23
 * @FilePath: \app\Http\Controllers\Admin\User\User\UserBankController.php
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

use App\Facade\Admin\User\User\AdminUserBankFacade;

class UserBankController extends Controller
{
    /**
     * 添加银行卡
     *
     * @param Request $request
     * @return void
     */
    public function addUserBank(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
               [
                    'user_id' => ['bail', new Required, new Numeric],
                    'bank_id' => ['bail', new Required, new Numeric],
                    'bank_number' => ['bail', new Required, new Numeric, new CheckUnique('user_bank', 'bank_number')],
                    'bank_account' => ['bail', new Required, new CheckString],
                    'bank_address' => ['bail', 'nullable', new CheckString],
                    'bank_front_id' => ['bail', 'nullable', new Numeric],
                    'bank_back_id' => ['bail', 'nullable', new Numeric],
                    'is_default' => ['bail', 'nullable', new Numeric],
                    'sort' => ['bail', 'nullable', new Numeric],
               ],
               []
           );

          $validated = $validator->validated();

          //p($validated);die;

          $result = AdminUserBankFacade::addUserBank(f($validated), $admin);
        }

        return $result;
    }


    /**
     * 设置默认银行卡
     *
     * @param Request $request
     * @return void
     */
    public function setUserDefaultBank(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('admin-role')) {

            $validator = Validator::make(
                $request->all(),
               [
                    'id' => ['bail', new Required, new Numeric],
                    'user_id' => ['bail', new Required, new Numeric],
               ],
               []
           );

           $validated = $validator->validated();

            $result = AdminUserBankFacade::setUserDefaultBank(f($validated), $admin);
        }

        return $result;
    }


    /**
     * 删除用户银行卡
     *
     * @param Request $request
     * @return void
     */
    public function deleteUserBank(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('admin-role')) {

            $validator = Validator::make(
                $request->all(),
               [
                     'id' => ['bail', new Required, new Numeric],
               ],
               []
           );

           $validated = $validator->validated();

           $result = AdminUserBankFacade::deleteUserBank(f($validated), $admin);
        }

        return $result;
    }

    /**
    * 获取用户 银行卡
    *
    * @param Request $request
    * @return void
    */
    public function getUserBank(Request $request)
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

            $result = AdminUserBankFacade::getUserBank(f($validated), $admin);
        }

        return $result;
    }
}
