<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-01 09:55:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-03 15:19:45
 * @FilePath: \app\Http\Controllers\Phone\Login\RegisterController.php
 */

namespace App\Http\Controllers\Phone\Login;

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

use App\Rules\Phone\RegisterPhone;

use App\Facade\Phone\Login\PhoneRegisterFacade;

class RegisterController extends Controller
{
    /**
     * 发送用户注册码
     */
    public function sendUserRegisterCode(Request $request)
    {

        $result = code(\config('phone.sendUserRegisterCodeError'));


        $validator = Validator::make(
            $request->all(),
            [
               'phone'=>['bail',new Required,new CheckString,new RegisterPhone],
            ],
            [ ]
        );

        $validated = $validator->validated();

        // p($validated);die;

        $result = PhoneRegisterFacade::sendUserRegisterCode($validated);

        return $result;
    }

    /**
     * 用户注册
     */
    public function userRegister(Request $request)
    {
        $result = code(\config('phone.userRegisterError'));

        $validator = Validator::make(
            $request->all(),
            [
               'phone'=>['bail',new Required,new CheckString,new RegisterPhone],
               'registerCode'=>['bail',new Required,new CheckString],
               'password'=>['bail',new Required,new CheckString],
               'inviteId'=>['bail','nullable',new CheckString],
               'inviteCode'=>['bail','nullable',new CheckString]
            ],
            [ ]
        );

        $validated = $validator->validated();

        // p($validated);die;

        $result = PhoneRegisterFacade::userRegister($validated);

        return $result;
    }

}
