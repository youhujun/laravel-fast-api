<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 14:46:01
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 16:18:28
 * @FilePath: \app\Http\Controllers\Phone\System\MapController.php
 */

namespace App\Http\Controllers\Phone\System;

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

use App\Facade\Phone\System\PhoneMapFacade;

class MapController extends Controller
{
	 /**
     * 获取默认选项
     */
    public function getLocationRegionByH5(Request $request)
    {

        $result = code(\config('phone_code.PhoneAuthError'));

        $user = Auth::guard('phone_token')->user();

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validated = $request->validate(
            [
                'latitude'=>['bail',new Required,new Numeric],
                'longitude'=>['bail',new Required,new Numeric],
            ],
            []);

            $result = PhoneMapFacade::getLocationRegionByH5($validated,$user);
        }

        //p($validated);die;
        return $result;
    }
}
