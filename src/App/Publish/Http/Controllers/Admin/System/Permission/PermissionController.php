<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 09:24:12
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 11:01:21
 * @FilePath: \app\Http\Controllers\Admin\System\Permission\PermissionController.php
 */

namespace App\Http\Controllers\Admin\System\Permission;

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


use App\Facade\Admin\System\Permission\AdminPermissionFacade;

class PermissionController extends Controller
{

    /**
     * 获取树形权限菜单
     * @return void
     */
    public function getTreePermission()
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
             $result =  AdminPermissionFacade::getTreePermission();
        }

        return $result;
    }

    /**
     * 添加菜单
     *
     * @param Request $result
     * @return void
     */
    public function addMenu(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('develop-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'parent_id'=>['bail',new Required,new Numeric],
                    'deep' => ['bail',new Required,new Numeric],
                    'sort' => ['bail',new Required,new Numeric],
                    "path" =>['bail',new Required,new CheckString,new CheckBetween(3,60)],
                    "component" =>['bail',new Required,new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "name" =>['bail','nullable',new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "redirect" =>['bail','nullable',new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "meta_title" =>['bail',new Required,new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "meta_icon" =>['bail','nullable',new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "meta_activeMenu" =>['bail','nullable',new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "alwaysShow"=>['bail','nullable',new CheckString],
                    "hidden"=>['bail','nullable',new CheckString],
                    "meta_affix"=>['bail','nullable',new CheckString],
                    "meta_breadcrumb"=>['bail','nullable',new CheckString],
                    "meta_noCache"=>['bail','nullable',new CheckString],
                ],
                []
            );

            $validated = $validator->validated();

            if(isset($validated['id']))
            {
                unset($validated['id']);
            }

            //p($validated);die;

            $result = AdminPermissionFacade::addMenu(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 更新菜单
     *
     * @param AddMenuRequest $request
     * @return void
     */
    public function updateMenu(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('develop-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'parent_id'=>['bail',new Required,new Numeric],
                    'deep' => ['bail',new Required,new Numeric],
                    'sort' => ['bail',new Required,new Numeric],
                    "path" =>['bail',new Required,new CheckString,new CheckBetween(3,60),],
                    "component" =>['bail',new Required,new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "name" =>['bail','nullable',new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "redirect" =>['bail','nullable',new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "meta_title" =>['bail',new Required,new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "meta_icon" =>['bail','nullable',new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "meta_activeMenu" =>['bail','nullable',new CheckString,new CheckBetween(3,60),new ChineseCodeNumberLine],
                    "alwaysShow"=>['bail','nullable',new CheckString],
                    "hidden"=>['bail','nullable',new CheckString],
                    "meta_affix"=>['bail','nullable',new CheckString],
                    "meta_breadcrumb"=>['bail','nullable',new CheckString],
                    "meta_noCache"=>['bail','nullable',new CheckString],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminPermissionFacade::updateMenu(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 树形控件移动
     *
     * @param Request $request
     * @return void
     */
    public function moveMenu(Request $request)
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
                    'dropType' => ['bail',new Required,new CheckString],
                    'sort' => ['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result =  AdminPermissionFacade::moveMenu(f($validated),$admin);
        }

       return $result;
    }

    /**
     * 删除菜单
     *
     * @param Request $request
     * @return void
     */
    public function deleteMenu(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('develop-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminPermissionFacade::deleteMenu(f($validated),$user);
        }

        return $result;
    }

    /**
     * 禁用或者开启菜单
     *
     * @param Request $request
     * @return void
     */
    public function switchMenu(Request $request)
    {
        $user = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($user)->allows('develop-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'switch'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminPermissionFacade::switchMenu(f($validated),$user);

        }

        return $result;


    }
}
