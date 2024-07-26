<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-28 08:06:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 01:39:52
 * @FilePath: \app\Http\Controllers\Admin\System\Bank\BankController.php
 */

namespace App\Http\Controllers\Admin\System\Bank;

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

use App\Facade\Admin\System\Bank\AdminBankFacade;

class BankController extends Controller
{
     //获取默认用户选项
    public function defaultBank(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
           $result =  AdminBankFacade::defaultBank();
        }

        return $result;
    }

    /**
     * 查找银行列表
     *
     * @param Request $request
     * @return void
     */
    public function findBank(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'find'=>['bail',new Required],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminBankFacade::findBank(f($validated));
        }

        return $result;
    }

    //获取银行列表
    public function getBank(Request $request)
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

            $result = AdminBankFacade::getBank(f($validated));
        }

        return $result;
    }

    /**
     * 添加银行
     *
     * @param AddBankRequest $request
     * @return void
     */
    public function addBank(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'bank_name'=>['bail',new Required,new ChineseCodeNumberLine, new CheckUnique('bank','bank_name','except','id')],
                    'bank_code'=>['nullable', new CheckUnique('bank','bank_code','except','id')],
                    'is_default'=>['bail',new Required,new Numeric],
                    'sort'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminBankFacade::addBank(f($validated),$admin);


        }

        return $result;
    }

    /**
     * 修改银行
     *
     * @param UpdateBankRequest $request
     * @return void
     */
    public function updateBank(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $id = checkId($request->input('id'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'bank_name'=>['bail',new Required,new ChineseCodeNumberLine, new CheckUnique('bank','bank_name',$id)],
                    'bank_code'=>['nullable', new CheckUnique('bank','bank_code',$id)],
                    'is_default'=>['bail',new Required,new Numeric],
                    'sort'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminBankFacade::updateBank(f($validated),$admin);
        }

        return $result;
    }


    /**
     * 删除银行
     *
     * @param Request $request
     * @return void
     */
    public function deleteBank(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminBankFacade::deleteBank(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 批量删除银行
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteBank(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'selectId'=>['bail',new Required,new CheckArray],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminBankFacade::multipleDeleteBank(f($validated),$admin);
        }

        return $result;
    }
}
