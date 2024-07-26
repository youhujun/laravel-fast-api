<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-19 09:54:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 15:54:29
 * @FilePath: \app\Http\Controllers\Admin\System\SystemConfig\VoiceConfigController.php
 */

namespace App\Http\Controllers\Admin\System\SystemConfig;

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

use App\Facade\Admin\System\SystemConfig\AdminVoiceConfigFacade;

class VoiceConfigController extends Controller
{

    /**
     * 查询
     */
    public function getVoiceConfig(Request $request)
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
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric],
                    'sortType'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            // p($validated);die;

            $result = AdminVoiceConfigFacade::getVoiceConfig(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 添加
     *
     * @param Request $request
     * @return void
     */
    public function addVoiceConfig(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    "voice_title" =>['bail',new Required,new CheckString],
                    "channle_name" =>['bail',new Required,new CheckString],
                    "channle_event" =>['bail',new Required,new CheckString,new CheckUnique('system_voice_config','channle_event')],
                    "voice_url" =>['bail','nullable',new CheckString],
                    "voice_path" =>['bail','nullable',new CheckString],
                    "note" =>['bail',new Required,new CheckString]
                ],
                [ ]
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminVoiceConfigFacade::addVoiceConfig(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 修改
     *
     * @param Request $request
     * @return void
     */
    public function updateVoiceConfig(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $id = checkId($request->input('id'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
           $validator = Validator::make(
                $request->all(),
                [
                    "id"=>['bail',new Required,new Numeric],
                    "voice_title" =>['bail',new Required,new CheckString],
                    "channle_name" =>['bail',new Required,new CheckString],
                    "channle_event" =>['bail',new Required,new CheckString,new CheckUnique('system_voice_config','channle_event',$id)],
                    "voice_url" =>['bail','nullable',new CheckString],
                    "voice_path" =>['bail','nullable',new CheckString],
                    "note" =>['bail',new Required,new CheckString]
                ],
                [ ]
            );

           $validated = $validator->validated();

           //p($validated);die;

           $result = AdminVoiceConfigFacade::updateVoiceConfig(f($validated),$admin);
        }

        return $result;
    }


    /**
     * 删除
     *
     * @param Request $request
     * @return void
     */
    public function deleteVoiceConfig(Request $request)
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
                [ ]
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminVoiceConfigFacade::deleteVoiceConfig(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 批量删除
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteVoiceConfig(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'selectId'=>['bail',new Required,new CheckArray]
                ],
                [ ]
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminVoiceConfigFacade::multipleDeleteVoiceConfig(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 获取所有提示配置
     */
    public function getAllSystemVoiceConfig(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                ],
                [ ]
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminVoiceConfigFacade::getAllSystemVoiceConfig(f($validated),$admin);
        }

        return $result;
    }
}
