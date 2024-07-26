<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-11 16:26:05
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-26 08:18:49
 * @FilePath: \app\Http\Controllers\Admin\User\User\UserTeamController.php
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

use  App\Facade\Admin\User\User\AdminUserTeamFacade;

class UserTeamController extends Controller
{
     /**
     * 获取用户的上级用户(推荐用户)
     *
     * @param Request $request
     * @return void
     */
    public function getUserSource(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'source_id' => ['bail', new Required, new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminUserTeamFacade::getUserSource($validated, $admin);
        }

        return $result;
    }

    /**
     * 获取用户下级团队
     */
    public function getUserLowerTeam(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => ['bail', new Required, new Numeric],
                    //级别类型
                    'lower_type' => ['bail', new Required, new Numeric],
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

            $result = AdminUserTeamFacade::getUserLowerTeam($validated, $admin);
        }

        return $result;
    }

}
