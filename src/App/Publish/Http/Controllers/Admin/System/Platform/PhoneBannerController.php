<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-22 13:38:04
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 21:40:57
 * @FilePath: \app\Http\Controllers\Admin\System\Platform\PhoneBannerController.php
 */

namespace App\Http\Controllers\Admin\System\Platform;

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

use App\Facade\Admin\System\Platform\AdminPhoneBannerFacade;

class PhoneBannerController extends Controller
{




    /**
     * 获取轮播图
     *
     * @param Request $request
     * @return void
     */
    public function getPhoneBanner(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {

             $validator = Validator::make(
                $request->all(),
                [
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric],
                    'sortType'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result = AdminPhoneBannerFacade::getPhoneBanner(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 添加首页轮播图
     *
     * @param Request $request
     * @return void
     */
    public function addPhoneBanner(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'album_picture_id'=>['bail',new Required,new Numeric],
                    'redirect_url'=>['bail',  'nullable', new CheckString],
                    'remark_info'=>['bail', 'nullable', new CheckString],
                    'sort'=>['bail', new Required, new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            if(isset($validated['id']))
            {
                unset($validated['id']);
            }

              //p($validated);die;

            $result = AdminPhoneBannerFacade::addPhoneBanner(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 修改轮播图
     * @param {Request} $request
     * @return {*}
     */
    public function updatePhoneBanner(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $id = checkId($request->input('id'));

        if (Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => ['bail', new Required, new Numeric],
                    'album_picture_id'=>['bail',new Required,new Numeric],
                    'redirect_url'=>['bail',  'nullable', new CheckString],
                    'remark_info'=>['bail', 'nullable', new CheckString],
                    'sort'=>['bail', new Required, new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminPhoneBannerFacade::updatePhoneBanner(f($validated), $admin);
        }

        return $result;

    }


    /**
     * 删除轮播图
     * @param {Request} $request
     * @return {*}
     */
    public function deletePhoneBanner(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if (Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id' => ['bail', new Required, new Numeric],
                    'is_delete' => ['bail', new Required, new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminPhoneBannerFacade::deletePhoneBanner(f($validated), $admin);
        }

        return $result;
    }
}
