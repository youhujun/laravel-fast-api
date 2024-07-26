<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-12 14:54:26
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-04 02:33:57
 * @FilePath: \app\Http\Controllers\Admin\User\Admin\AdministratorController.php
 */


namespace App\Http\Controllers\Admin\User\Admin;

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

use App\Facade\Admin\User\Admin\AdministratorFacade;

class AdministratorController extends Controller
{

    /**
     * 获取所有管理用户
     *
     * @param Request $request
     * @return void
     */
    public function getDefaultAdmin(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $result = AdministratorFacade::getDefaultAdmin();
        }

        return $result;
    }

    /**
     * 查找管理员
     *
     * @return void
     *
     */
    public function findAdmin(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
             $validator = Validator::make(
                $request->all(),
                [
                    'find'=>['bail','nullable',new CheckString]
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdministratorFacade::findAdmin($validated,$admin);
        }

        return $result;
    }



    //获取管理员列表
    public function getAdmin(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('super-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'find'=>['bail','nullable',new CheckString],
                    'findSelectIndex'=>['bail','nullable',new Numeric],
                    'timeRange'=>['bail','nullable',new CheckArray],
                    'switch'=>['bail','nullable',new Numeric],
                    'sortType'=>['bail',new Required,new Numeric],
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric],
                    'isExport'=>['bail','nullable',new Numeric],
                    'exportType'=>['bail','nullable',new Numeric],
                    'status'=>['bail','nullable',new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdministratorFacade::getAdmin(f($validated));
        }

        return $result;
    }

    /**
     * 添加用户
     *
     * @param AddAdminRequest $request
     * @return void
     */
    public function addAdmin(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'user_id'=>['bail',new Required,new Numeric,new CheckUnique('admin','user_id')],
                    'role'=>['bail','nullable',new CheckArray],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdministratorFacade::addAdmin(f($validated),$admin);

        }

        return $result;
    }

    /**
     * 修改管理员
     *
     * @param UpdateAdminRequest $request
     * @return void
     */
    public function updateAdmin(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $id = $request->input('id');

        if(Gate::forUser($admin)->allows('super-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>[new Required,new Numeric],
                    'user_id'=>[new Required,new Numeric,new CheckUnique('admin','user_id',checkId($id))],
                    'role'=>['bail','nullable',new CheckArray]
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdministratorFacade::updateAdmin(f($validated),$admin);

        }

        return $result;
    }

    /**
     * 禁用用户
     *
     * @param Request $request
     * @return void
     */
    public function disableAdmin(Request $request)
    {

        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>[new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            // p($validated);die;

            $result = AdministratorFacade::disableAdmin($validated,$admin);
        }

        return $result;
    }

    /**
     * 批量禁用用户
     *
     * @param Request $request
     * @return void
     */
    public function multipleDisableAdmin(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'selectId'=>['bail',new Required,new CheckArray],
                ],
                []
            );

            $validated = $validator->validated();


            $result = AdministratorFacade::multipleDisableAdmin($validated,$admin);
        }

        return $result;
    }

    /**
     * 删除用户
     *
     * @param Request $request
     * @return void
     */
    public function deleteAdmin(Request $request)
    {

        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {
             $validator = Validator::make(
                $request->all(),
                [
                    'id'=>[new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            // p($validated);die;

            $result = AdministratorFacade::deleteAdmin($validated,$admin);
        }

        return $result;
    }

    /**
     * 批量删除用户
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteAdmin(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                  'selectId'=>['bail',new Required,new CheckArray],
               ],
               []
           );

           $validated = $validator->validated();

            $result = AdministratorFacade::multipleDeleteAdmin($validated,$admin);
        }

        return $result;
    }
}
