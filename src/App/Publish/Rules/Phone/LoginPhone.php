<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-10-09 14:15:28
 * @LastEditors: lak 15931400746@163.com
 * @LastEditTime: 2023-08-23 16:28:17
 */

namespace App\Rules\Phone;

use Illuminate\Contracts\Validation\Rule;

use App\Models\User\User;

class LoginPhone implements Rule
{
    protected $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
        $result = true;

        if (isset($value) || !empty($value))
        {

            $phonePartten = '/^(13[0-9]|14[5|7]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/';

            $phoneResult = preg_match($phonePartten, $value);

            if (!$phoneResult)
            {
                $result = false;
                $this->message = '手机号不正确';
            }
            else
            {
                //手机号审核通过后,要确保数据库中有该用户,并且该用户是可用的
                $userCollection = User::where([['phone', '=', $value], ['switch', '=', 1]])->get();

                if (!$userCollection->count())
                {
                    $result = false;
                    $this->message = '账号异常,请联系客服';
                }
            }
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
        return $this->message;
    }
}
