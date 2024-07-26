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

use \App\Facade\Admin\Log\AdminLogFacade;

class AdminLogController extends Controller
{

    /**
     * 获取登录日志
     *
     * @param Request $request
     * @return void
     */
    public function getAdminLoginLog(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
               [
                'admin_id'=>['bail','nullable',new CheckBetween(0,50),new Numeric],
                'timeRange'=>['bail','nullable',new CheckArray],
                'status'=>['bail','nullable',new Numeric],
                'sortType'=>['bail','nullable',new Numeric],
                'currentPage'=>['bail','nullable',new Numeric],
                'pageSize'=>['bail','nullable',new Numeric]
               ],
               []
           );

           $validated = $validator->validated();

           //p($validated);die;

           $result = AdminLogFacade::getAdminLoginLog($validated,$admin);

        }

        return $result;
    }

    /**
     * 删除日志
     *
     * @param Request $request
     * @return void
     */
    public function deleteAdminLoginLog(Request $request)
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

           $result = AdminLogFacade::deleteAdminLoginLog($validated,$admin);
        }

        return $result;
    }

    /**
     * 多选删除
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteAdminLoginLog(Request $request)
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

            $result = AdminLogFacade::multipleDeleteAdminLoginLog($validated,$admin);
        }

        return $result;
    }

        /**
     * 获取事件日志
     *
     * @return void
     */
    public function getAdminEventLog(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                    'admin_id'=>['bail','nullable',new CheckBetween(0,50),new Numeric],
                    'timeRange'=>['bail','nullable',new CheckArray],
                    'eventType'=>['bail','nullable',new Numeric],
                    'sortType'=>['bail','nullable',new Numeric],
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric]
               ],
               []
           );

           $validated = $validator->validated();

            $result = AdminLogFacade::getAdminEventLog($validated,$admin);
        }

        return $result;
    }

    /**
     * 删除事件日志
     *
     * @param Request $request
     * @return void
     */
    public function deleteAdminEventLog(Request $request)
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

            $result = AdminLogFacade::deleteAdminEventLog($validated,$admin);
        }

        return $result;
    }

    /**
     * 多选删除
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteAdminEventLog(Request $request)
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

            $result = AdminLogFacade::multipleDeleteAdminEventLog($validated,$admin);
        }

        return $result;
    }
}
