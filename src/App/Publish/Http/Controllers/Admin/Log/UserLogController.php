<?php

namespace App\Http\Controllers\Admin\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

use App\Rules\Public\CheckArray;
use App\Rules\Public\CheckString;
use App\Rules\Public\ChineseCodeNumberLine;
use App\Rules\Public\Numeric;
use App\Rules\Public\Required;
use App\Rules\Public\CheckBetween;
use App\Rules\Public\CheckUnique;
use App\Rules\Public\LetterNumberUnderLine;

use App\Facade\Admin\Log\AdminUserLogFacade;

class UserLogController extends Controller
{
     /*
     * 获取登录日志
     *
     * @param Request $request
     * @return void
     */
    public function getUserLoginLog(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                  'user_id'=>['bail','nullable',new CheckBetween(0,50),new Numeric],
                  'timeRange'=>['bail','nullable',new CheckArray],
                  'status'=>['bail','nullable',new Numeric],
                  'sortType'=>['bail','nullable',new Numeric],
                  'currentPage'=>['bail','nullable',new Numeric],
                  'pageSize'=>['bail','nullable',new Numeric]
               ],
               []
           );

           $validated = $validator->validated();

           // p($validated);die;

           $result = AdminUserLogFacade::getUserLoginLog(f($validated),$admin);

        }

        return $result;
    }

    /**
     * 删除日志
     *
     * @param Request $request
     * @return void
     */
    public function deleteUserLoginLog(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                  'id'=>['bail',new Required,new Numeric],
               ],
               []
           );

           $validated = $validator->validated();

            $result = AdminUserLogFacade::deleteUserLoginLog($validated,$admin);
        }

        return $result;
    }

    /**
     * 多选删除
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteUserLoginLog(Request $request)
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

            $result = AdminUserLogFacade::multipleDeleteUserLoginLog($validated,$admin);
        }

        return $result;
    }

    /**
     * 获取事件日志
     *
     * @return void
     */
    public function getUserEventLog(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                    'user_id'=>['bail','nullable',new CheckBetween(0,50),new Numeric],
                    'timeRange'=>['bail','nullable',new CheckArray],
                    'eventType'=>['bail','nullable',new Numeric],
                    'sortType'=>['bail','nullable',new Numeric],
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric]
               ],
               []
           );

           $validated = $validator->validated();

            $result = AdminUserLogFacade::getUserEventLog($validated,$admin);
        }

        return $result;
    }

    /**
     * 删除事件日志
     *
     * @param Request $request
     * @return void
     */
    public function deleteUserEventLog(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('super-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                  'id'=>['bail',new Required,new Numeric],
               ],
               []
           );

           $validated = $validator->validated();

           $result = AdminUserLogFacade::deleteUserEventLog($validated,$admin);
        }

        return $result;
    }

    /**
     * 多选删除
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteUserEventLog(Request $request)
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

           $result = AdminUserLogFacade::multipleDeleteUserEventLog($validated,$admin);
        }

        return $result;
    }

}
