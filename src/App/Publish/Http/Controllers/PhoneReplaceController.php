<?php

namespace App\Http\Controllers;

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

use App\Facade\ReplaceFacade;

class PhoneReplaceController extends Controller
{
     /**
     * 获取默认选项
     */
    public function defaultReplace(Request $request)
    {
        $result = code(\config('phone_code.PhoneAuthError'));

        $user = Auth::guard('phone_token')->user();

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'type'=>['bail','nullable',new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result =  ReplaceFacade::defaultReplace(f($validated),$user);
        }

        return $result;
    }

    /**
     * 查找选项
     *
     * @param Request $request
     * @return void
     */
    public function findReplace(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'find'=>['bail',new Required],
                    'type'=>['bail','nullable',new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            $result = ReplaceFacade::findReplace(f($validated),$user);
        }

        return $result;
    }


    /**
     * 查询
     */
    public function getReplace(Request $request)
    {
        $result = code(\config('phone_code.PhoneAuthError'));

        $user = Auth::guard('phone_token')->user();

        if(Gate::forUser($user)->allows('phone-user-role'))
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

            $result = ReplaceFacade::getReplace(f($validated));
        }

        return $result;
    }

    /**
     * 添加
     *
     * @param Request $request
     * @return void
     */
    public function addReplace(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'mysql_replace_name'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('table','field')],
                    'sort'=>['bail',new Required,new Numeric]
                ],
                [ ]
            );

            $validated = $validator->validated();

            if(isset($validated['id']) && $validated['id'] === 0)
            {
                unset($validated['id']);
            }

            $result = ReplaceFacade::addReplace(f($validated),$user);
        }

        return $result;
    }

    /**
     * 修改
     *
     * @param Request $request
     * @return void
     */
    public function updateReplace(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        $id = checkId($request->input('id'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
           $validated = $request->validated();

          $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'mysql_replace_name'=>['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine,new CheckUnique('table','field',$id)],
                    'is_default'=>['bail',new Required,new Numeric],
                    'sort'=>['bail',new Required,new Numeric],
                ],
                [ ]
            );

           $validated = $validator->validated();

           $result = ReplaceFacade::updateReplace(f($validated),$user);
        }

        return $result;
    }

    /**
     * 树形控件移动
     *
     * @param Request $request
     * @return void
     */
    public function moveReplace(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('super-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'parent_id'=>new Required,
                    'dropType'=>new Required,
                    'sort'=>new Required,
                ],
                [ ]
            );

            $validated = $validator->validated();

            $result = ReplaceFacade::moveReplace(f($validated),$user);
        }

       return $result;
    }


    /**
     * 删除
     *
     * @param Request $request
     * @return void
     */
    public function deleteReplace(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'is_delete'=>['bail',new Required,new Numeric],
                ],
                [ ]
            );

            $validated = $validator->validated();

            $result = ReplaceFacade::deleteReplace(f($validated),$user);
        }

        return $result;
    }

    /**
     * 批量删除
     *
     * @param Request $request
     * @return void
     */
    public function multipleDeleteReplace(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'selectId'=>['bail',new Required,new CheckArray],
                    'is_delete'=>['bail',new Required,new Numeric],
                ],
                [ ]
            );

            $validated = $validator->validated();

            $result = ReplaceFacade::multipleDeleteReplace(f($validated),$user);
        }

        return $result;
    }

    /**
     * 禁用
     *
     * @param Request $request
     * @return void
     */
    public function disableReplace(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'switch'=>['bail',new Required,new Numeric]
                ],
                [ ]
            );

            $validated = $validator->validated();

            $result = ReplaceFacade::disableReplace(f($validated),$user);
        }

        return $result;
    }

    /**
     * 批量删除
     *
     * @param Request $request
     * @return void
     */
    public function multipleDisableReplace(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'selectId'=>['bail',new Required,new CheckArray],
                    'switch'=>['bail',new Required,new Numeric]
                ],
                [ ]
            );

            $validated = $validator->validated();

            $result = ReplaceFacade::multipleDisableReplace(f($validated),$user);
        }

        return $result;
    }

    /**
     * 获取 绑定地区
     *
     * @return void
     */
    public function getReplaceUnionRegion(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'replace_id'=>['bail',new Required,new Numeric]
                ],
                [
                    'replace_id.required'=>'必须有id'

                ]
            );

            $validated = $validator->validated();

            $result = ReplaceFacade::getReplaceUnionRegion(f($validated),$user);
        }

        return $result;
    }

    /**
     * 更新
     *
     * @return void
     */
    public function updateReplaceUnionRegion(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'replace_id'=>['bail',new Required,new Numeric],
                    'region_id_array'=>['bail',new Required,new CheckArray],
                ],
                [ ]
            );

            $validated = $validator->validated();

            $result = ReplaceFacade::updateReplaceConfigUnionRegion(f($validated),$user);
        }

        return $result;
    }

}
