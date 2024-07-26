<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-11 17:22:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 10:50:14
 * @FilePath: \app\Http\Controllers\Admin\User\User\UserAccountController.php
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

use App\Facade\Admin\User\User\AdminUserAccountFacade;

class UserAccountController extends Controller
{

    /**
     * 操作用户账户
     *
     * @param Request $request
     * @return void
     */
    public function setUserAccount(Request $request )
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $user = Auth::guard('admin_token')->user();

        if(Gate::forUser($user)->allows('admin-role'))
        {

             $validator = Validator::make(
                $request->all(),
                [
                    'find'=>['bail','nullable',new CheckString],
                    'user_id'=> ['bail',new Required,new Numeric],
                    'account_type'=> ['bail',new Required,new Numeric],
                    'action_type'=> ['bail',new Required,new Numeric],
                    'amount'=> ['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminUserAccountFacade::setUserAccount(f($validated),$user);
        }

        return $result;
    }


    /**
     * 获取用户账户日志
     *
     * @param Request $request
     * @return void
     */
    public function getUserAccountLog(Request $request )
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $user = Auth::guard('admin_token')->user();

        if(Gate::forUser($user)->allows('admin-role'))
        {

             $validator = Validator::make(
                $request->all(),
                [
                    'timeRange'=>['bail','nullable',new CheckArray],
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric],
                    'sortType'=>['bail',new Required,new Numeric],
                    'user_id'=> ['bail',new Required,new Numeric],
                    'account_type'=> ['bail',new Required,new Numeric],
                    'action_type'=> ['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

             //p($validated);die;

            $result = AdminUserAccountFacade::getUserAccountLog(f($validated),$user);
        }

        return $result;
    }

}
