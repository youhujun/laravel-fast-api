<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 08:01:25
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 09:40:40
 * @FilePath: \app\Http\Controllers\Phone\Order\PayOrderController.php
 */

namespace App\Http\Controllers\Phone\Order;

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

use App\Facade\Phone\Pay\PhonePayFacade;

class PayOrderController extends Controller
{
	 /**
     * 获取默认选项
     */
    public function testPayOrder(Request $request)
    {
        $result = code(\config('phone_code.PhoneAuthError'));

        $user = Auth::guard('phone_token')->user();

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'order_id'=>['bail','nullable',new Numeric],
                    'pay_type'=>['bail','nullable',new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;
            //PhonePayFacade::test();die;

            $result =  PhonePayFacade::testPayOrder(f($validated),$user);
        }

        return $result;
    }


}
