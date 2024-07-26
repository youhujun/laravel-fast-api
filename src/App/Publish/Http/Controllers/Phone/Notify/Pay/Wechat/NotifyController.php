<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-12 10:17:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-12 12:58:59
 * @FilePath: \app\Http\Controllers\Phone\Notify\Pay\Wechat\NotifyController.php
 */

namespace App\Http\Controllers\Phone\Notify\Pay\Wechat;

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

use App\Facade\Phone\Notify\PhonePayNotifyFacade;

class NotifyController extends Controller
{
	 /**
     * 获取默认选项
     */
    public function wechatJsPayNotify(Request $request)
    {
        $inWechatpaySignature = $request->header('Wechatpay-Signature');
        $inWechatpayTimestamp = $request->header('Wechatpay-Timestamp');
        $inWechatpaySerial = $request->header('Wechatpay-Serial');
        $inWechatpayNonce = $request->header('Wechatpay-Nonce');
        $inBody = file_get_contents('php://input');

        $notifyData = [
            '$inWechatpaySignature' => $inWechatpaySignature,
            '$inWechatpayTimestamp' => $inWechatpayTimestamp,
            '$inWechatpaySerial' => $inWechatpaySerial,
            '$inWechatpayNonce' => $inWechatpayNonce,
            '$inBody' => $inBody
        ];

        //p($notifyData);die;

        $result = PhonePayNotifyFacade::wechatJsPayNotify($notifyData);

        return $result;
    }


}
