<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-08-02 14:58:42
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 11:28:44
 */

namespace App\Rules\Phone;

use Illuminate\Contracts\Validation\Rule;

use App\Models\User\User;

use App\Exceptions\Common\RuleException;

class RegisterPhone implements Rule
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
                throw new RuleException('RulePhoneError', $attribute);

            }
            else
            {
                //要确保数据库中没有该手机号
                $userCollection = User::withTrashed()->where([['phone', '=', $value]])->get();

                if ($userCollection->count())
                {
                    $result = false;
                    $this->message = '该手机号已经被注册';
                    throw new RuleException('RulePhoneIsRegister', $attribute);

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
        return  $this->message;
    }
}
