<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-09-08 17:22:16
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-27 20:12:04
 * @FilePath: \base.laravel.com\app\Rules\Common\IdNumber.php
 */

namespace App\Rules\Common;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class IdNumber implements Rule
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
        $result = true;

        if(isset($value) && !empty($value))
        {
            $idNumberPartten = "/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/";

            $idNumberResult = preg_match($idNumberPartten, $value);

            if(!$idNumberResult)
            {
                $result = false;
            }

        }

        if(!$result)
        {
            $this->message = '身份证号不正确';
            throw new RuleException('RuleIdNumberError');
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
