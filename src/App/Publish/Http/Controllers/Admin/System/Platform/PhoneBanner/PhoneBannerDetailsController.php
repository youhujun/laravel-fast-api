<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-28 11:51:00
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-12 23:09:06
 * @FilePath: \app\Http\Controllers\Admin\System\Platform\PhoneBanner\PhoneBannerDetailsController.php
 */

namespace App\Http\Controllers\Admin\System\Platform\PhoneBanner;

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

use  App\Facade\Admin\System\Platform\PhoneBanner\AdminPhoneBannerDetailsFacade;

class PhoneBannerDetailsController extends Controller
{
    /**
     * 修改轮播图图片
     *
     * @param Request $request
     * @return void
     */
    public function updatePhoneBannerPicture(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'album_picture_id'=>['bail',new Required,new Numeric]
                ],
                [ ]
            );

           $validated = $validator->validated();

           //p($validated);die;

           $result = AdminPhoneBannerDetailsFacade::updatePhoneBannerPicture(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 修改轮播图跳转
     *
     * @param Request $request
     * @return void
     */
    public function updatePhoneBannerUrl(Request $request)
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
                    'redirect_url'=>['bail',new Required,new CheckString]
                ],
                [ ]
            );

           $validated = $validator->validated();

           //p($validated);die;

           $result = AdminPhoneBannerDetailsFacade::updatePhoneBannerUrl(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 修改轮播图跳转
     *
     * @param Request $request
     * @return void
     */
    public function updatePhoneBannerSort(Request $request)
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
                    'sort'=>['bail',new Required,new Numeric]
                ],
                [ ]
            );

           $validated = $validator->validated();

           //p($validated);die;

           $result = AdminPhoneBannerDetailsFacade::updatePhoneBannerSort(f($validated),$admin);
        }

        return $result;
    }

        /**
     * 修改轮播图跳转
     *
     * @param Request $request
     * @return void
     */
    public function updatePhoneBannerBakInfo(Request $request)
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
                    'remark_info'=>['bail',new Required,new CheckString]
                ],
                [ ]
            );

           $validated = $validator->validated();

           //p($validated);die;

           $result = AdminPhoneBannerDetailsFacade::updatePhoneBannerBakInfo(f($validated),$admin);
        }

        return $result;
    }
}
