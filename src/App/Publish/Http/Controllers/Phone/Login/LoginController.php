<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-27 10:32:47
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-08-01 12:27:15
 * @FilePath: \app\Http\Controllers\Phone\Login\LoginController.php
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

use App\Rules\Phone\LoginPhone;
use App\Rules\Phone\Phone;

use App\Facade\Phone\Login\PhoneLoginFacade;
use App\Facade\Public\Wechat\WechatOfficialFacade;

class LoginController extends Controller
{
	  /**
     * 通过手机号 密码登录
     *
     * @param LoginRequest $request
     * @return void
     */
    public function loginByUser(Request $request)
    {
        $result = code(\config('phone_code.LoginByUserError'));

        $validator = Validator::make(
            $request->all(),
            [
                 'phone'=>['bail',new Required,new CheckString,new LoginPhone],
                 'password'=>['bail',new Required,new CheckString,new CheckBetween(6,12)],
            ],
            [ ]
        );

        $validated = $validator->validated();

        $validated['ip'] = $request->getClientIp();

        //p($validated);die;

        $result = PhoneLoginFacade::loginByUser($validated);

        return $result;
    }

     /**
     * 发送手机验证码
     *
     * @param Request $request
     * @return void
     */
    public function sendVerifyCode(Request $request)
    {
        $result = code(config('phone_code.SendPhoneCodeError'));

        $validator = Validator::make(
            $request->all(),
            [
               'phone'=>['bail',new Required,new CheckString,new LoginPhone],
            ],
            [ ]
        );

        $validated = $validator->validated();

        $result = PhoneLoginFacade::sendVerifyCode($validated);

        return $result;
    }

     /**
     * 通过手机号验证码登录
     *
     * @param Request $request
     * @return void
     */
    public function loginByPhone(Request $request)
    {
         $result = code(\config('phone_code.LoginByPhoneError'));
         $validator = Validator::make(
            $request->all(),
            [
                'phone'=>['bail',new Required,new CheckString,new LoginPhone],
                'code'=>['bail',new Required,new CheckString,'regex:/^\d{4}$/'],
            ],
            [ ]
        );

        $validated = $validator->validated();

        $validated['ip'] = $request->getClientIp();

        //p($validated);die;

        $result = PhoneLoginFacade::loginByPhone($validated);

        return $result;

    }

	 /**
     * 发送手机验证码 忘记密码
     *
     * @param Request $request
     * @return void
     */
    public function sendPasswordCode(Request $request)
    {
		
        $result = code(config('phone_code.SendPhoneCodeError'));

        $validator = Validator::make(
            $request->all(),
            [
               'phone'=>['bail',new Required,new CheckString,new LoginPhone],
            ],
            [ ]
        );

        $validated = $validator->validated();

        $result = PhoneLoginFacade::sendVerifyCode($validated);

        return $result;
    }

	/**
	 * 重置手机密码
	 *
	 * @param  Request $request
	 */
	public function restPasswordByPhone(Request $request)
	{
		 $result = code(\config('phone_code.RestPasswordByPhoneError'));

		 $validator = Validator::make(
            $request->all(),
            [
                'phone'=>['bail',new Required,new CheckString,new LoginPhone],
                'code'=>['bail',new Required,new CheckString,'regex:/^\d{4}$/'],
				'password'=>['bail',new Required,new CheckString,new CheckBetween(6,12)],
            ],
            [ ]
        );
		 $validated = $validator->validated();

		$result = PhoneLoginFacade::restPasswordByPhone($validated);

        return $result;


	}


    /**
     * 微信公众号获取授权码登录用(获取用户信息)
     *
     * @param  Request $request
     */
    public function wechatOfficialGetCodeByLogin(Request $request)
    {
        $result =  code(config('common_code.WechatOfficialGetCodeError'));

        $result = WechatOfficialFacade::wechatOfficialGetCode(20);

        return $result;
    }

    /**
     * 微信登录授权
     *
     * @param  Request $request
     */
    public function wecahtOfficialAuthToLogin(Request $request)
    {
        $result =  code(config('common_code.WechatOfficialAuthError'));

        $validated = $request->validate(
        [
            'code'=>['bail',new Required,new CheckString],
            'state'=>['bail','nullable',new CheckString],
        ],
        []);

        $validated['ip'] = $request->getClientIp();
        //获取用户信息
        $validated['scope_type'] = 20;

        //p($validated);die;

        $result = WechatOfficialFacade::wechatOfficialAuth($validated);

        return $result;
    }

        /**
     * app 一键登录注册
     *
     * @param Request $request
     * @return void
     */
    public function univerifyLogin(Request $request)
    {
        $validated = $request->validate(
        [
            'provider'=>['bail',new Required,new CheckString],
            'openid'=>['bail',new Required,new CheckString],
            'access_token'=>['bail',new Required,new CheckString],
        ],
        [
            'provider.required' => '必须有provider',
            'openid.required' => '必须有openid',
            'access_token.required' => '必须有access_token',
        ]);

        $validated['ip'] = $request->getClientIp();

        //Log::debug(['$validated'=> $validated]);

        //p($validated);die;

        $result = PhoneLoginFacade::univerifyLogin($validated);

        return $result;

    }

    /**
     * 通过用户id登录,开发测试用
     *
     * @param  Request $request
     */
    public function loginByUserId(Request $request)
    {
        $validated = $request->validate(
        [
            'user_id'=>['bail',new Required,new Numeric],
        ],[]);

        $validated['ip'] = $request->getClientIp();

        // p($validated);die;

        $result = PhoneLoginFacade::loginByUserId($validated);

        return $result;

    }

    /**
     * 静默授权获取code
     *
     * @param  Request $request
     */
    public function wechatOfficialGetCode(Request $request)
    {
        $result = code(\config('phone_code.PhoneAuthError'));

        $user = Auth::guard('phone_token')->user();

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $result = WechatOfficialFacade::wechatOfficialGetCode(10);
        }

        return $result;
    }

    /**
     * 静默授权
     *
     * @param  Request $request
     */
    public function wecahtOfficialAuth(Request $request)
    {
        $result = code(\config('phone_code.PhoneAuthError'));

        $user = Auth::guard('phone_token')->user();

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validated = $request->validate(
            [
                'code'=>['bail',new Required,new CheckString],
                'state'=>['bail','nullable',new CheckString],
            ],
            []);

            $validated['ip'] = $request->getClientIp();
            //静默授权
            $validated['scope_type'] = 10;

            $result = WechatOfficialFacade::wechatOfficialAuth($validated);
        }

        return $result;
    }


     /**
     * 获取用户信息
     *
     * @param Request $request
     * @return void
     */
    public function getUserInfo(Request $request)
    {
        $user = Auth::guard('phone_token')->user();

        $result = code(\config('phone_code.PhoneAuthError'));

        if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $result = PhoneLoginFacade::getUserInfo($user);
        }

        return $result;
    }

	 /**
     * 发送手机验证码
     *
     * @param Request $request
     * @return void
     */
    public function sendBindCode(Request $request)
    {
        $result = code(config('phone_code.SendPhoneCodeError'));

        $validator = Validator::make(
            $request->all(),
            [
               'phone'=>['bail',new Required,new CheckString,new Phone],
            ],
            [ ]
        );

        $validated = $validator->validated();

        $result = PhoneLoginFacade::sendVerifyCode($validated);

        return $result;
    }

	/**
	 * 微信登录绑定手机号
	 *
	 * @param  Request $request
	 */
	public function bindPhone(Request $request)
	{
		$user = Auth::guard('phone_token')->user();

		$result = code(\config('phone_code.PhoneAuthError'));

		if(Gate::forUser($user)->allows('phone-user-role'))
        {
            $validated = $request->validate(
            [
				'phone'=>['bail',new Required,new CheckString,new CheckUnique('users','phone')],
                'code'=>['bail',new Required,new CheckString,'regex:/^\d{4}$/'],
                'password'=>['bail',new Required,new CheckString,new CheckBetween(6,12)],
            ],
            []);

            //p($validated);die;

            $result = PhoneLoginFacade::bindPhone(f($validated),$user);
        }

		return $result;
	}


    /**
     * 检测是否定登录
     *
     * @return void
     */
    public function checkIsLogin(Request $request)
    {
        $result = code(['code'=> 0,'msg'=>'用户已经成功登录!']);

        return $result;
    }

    /**
     * 用户退出
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $ip = $request->getClientIp();

        // p($ip);die;

        $result = PhoneLoginFacade::logout($ip);

        return $result;
    }





}
