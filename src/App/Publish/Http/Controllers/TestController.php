<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-04-06 21:26:55
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-19 11:01:09
 * @FilePath: \app\Http\Controllers\TestController.php
 */

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Cache;

use App\Facade\ReplaceFacade;

use App\Exceptions\Admin\CommonException;

use App\Facade\Public\Sms\TencentSmsFacade;

use App\Facade\Phone\User\PhoneUserSourceFacade;

use App\Models\User\User;

use App\Facade\Public\Wechat\WechatOfficialFacade;

use App\Facade\Public\Wechat\Pay\WechatJsPayFacade;

use App\Facade\Public\Wechat\Pay\WechatJsPayDecryptFacade;

use App\Models\System\SystemVoiceConfig;

use App\Facade\Phone\Websocket\PhoneSocketFacade;

use Illuminate\Support\Facades\Notification;
use App\Notifications\SendExceptionMessageNoification;

use App\Facade\Public\Store\QiNiuFacade;

use App\Facade\Admin\System\SystemConfig\AdminVoiceConfigFacade;

class TestController extends Controller
{
    public function test()
    {
       p('test');

       //AdminVoiceConfigFacade::test();
    }

    public function testEvent()
    {
        echo "测试事件";
    }
}
