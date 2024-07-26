<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 11:15:22
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-31 21:19:40
 * @FilePath: \app\Http\Controllers\Admin\Login\AdminLoginController.php
 */

namespace App\Http\Controllers\Admin\Login;

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

use App\Rules\Admin\Login\LoginAdminAccount;

use App\Facade\Admin\Login\AdminLoginFacade;
use App\Facade\Admin\System\Permission\AdminPermissionFacade;

class AdminLoginController extends Controller
{
	 /**
     * 获取默认选项
     */
    public function login(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['bail',new Required,new CheckString,new CheckBetween(4,30),new LoginAdminAccount],
                'password' =>[ 'bail',new Required,new CheckString,new CheckBetween(6,12)],
            ],
            []
        );

        $validated = $validator->validated();

        //p($validated);die;

        $validated['ip'] = $request->getClientIp();

        $result = AdminLoginFacade::authLogin($validated);

        return $result;
    }

    /**
     * 获取登录管理员信息
     */
    public function getAdminInfo(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $result = AdminLoginFacade::getAdminInfo($admin);
        }

        return $result;

    }

    /**
     * 获取树形权限菜单
     * @return void
     */
    public function getTreePermission(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
             $result = AdminPermissionFacade::getTreePermission($admin);
        }

        return $result;
    }

    /**
     * 管理员退出
     *
     * @param  Request $request
     */
    public function logout(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $ip = $request->getClientIp();

            $result = AdminLoginFacade::logout($admin,$ip);
        }
        return $result;
    }



}
