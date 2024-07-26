<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-05 12:03:58
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 21:58:00
 * @FilePath: \app\Rules\Admin\Login\LoginAdminAccount.php
 */

namespace App\Rules\Admin\Login;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class LoginAdminAccount implements Rule
{
    protected $message;


    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
         $result = false;

        if(isset($value) && !empty($value))
        {
            //验证手机号
            $phonePartten = '/^(13[0-9]|14[5|7]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/';

            $phoneResult = preg_match($phonePartten, $value);

            if($phoneResult)
            {
                $result = true;
            }

            //验证邮箱
            $emailPartten = '/([a-zA-Z0-9_]+)@(([a-zA-Z0-9]+)\.){1,2}[a-z]{2,3}/';

            $emailResult = preg_match($emailPartten, $value);

            if($emailResult)
            {
                $result = true;
            }

            //验证账号  帐号是否合法(字母开头，允许5-16字节，允许字母数字下划线
            $accountNamePartten = '/^[a-zA-Z][a-zA-Z0-9_]{4,15}$/';

            $accountNameResult = preg_match($accountNamePartten, $value);

            if($accountNameResult)
            {
                 $result = true;
            }

        }

        if(!$result)
        {
             $this->message = "登录账号非法!";
             throw new RuleException('RuleLoginAccountError');
        }

        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        //return 'The validation error message.';
        return  $this->message;
    }
}
