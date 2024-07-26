<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 17:35:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 18:37:01
 * @FilePath: \app\Http\Controllers\Phone\User\User\UserController.php
 */

namespace App\Http\Controllers\Phone\User\User;

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

use App\Rules\Common\IdNumber;

use App\Facade\Phone\User\User\PhoneUserFacade;

class UserController extends Controller
{
	 /**
     * 获取默认选项
     */
    public function realAuthApply(Request $request)
    {
        $result = code(\config('phone_code.PhoneAuthError'));

        $user = Auth::guard('phone_token')->user();

        $id = $user->id;

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'real_name'=>['bail','required',new CheckString],
                    'id_number'=>['bail','required',new IdNumber,new CheckUnique('user_info','id_number',$id)],
                    'id_card_front_id'=>['bail','required',new Numeric],
                    'id_card_back_id'=>['bail','required',new Numeric],
                ],
                [ ]
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result =  PhoneUserFacade::realAuthApply(f($validated),$user);
        }

        return $result;
    }
}
