<?php
/*
 * @Descripttion:
 * @version:
 * @Author: Lak
 * @Date: 2023-08-14 10:19:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-07 22:03:20
 */

namespace App\Rules\Admin\Login;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class Password implements Rule
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
            $passwordPartten = "/^(?=.*\d)(?=.*[a-zA-Z]).{6,10}$/";

            $passwordResult = preg_match($passwordPartten, $value);

            if (!$passwordResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '密码必须由数字+字母6-10位组成';

            throw new RuleException('RuleAdminPasswordError', $attribute);
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
        return  $this->message;
    }
}
