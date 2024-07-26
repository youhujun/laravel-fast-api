<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-22 14:53:49
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 11:26:45
 * @FilePath: \app\Rules\Admin\Common\sortType.php
 */

namespace App\Rules\Admin\Common;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class sortType implements Rule
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
            $sortTypePartten = "/^[1234]$/";

            $sortTypeResult = preg_match($sortTypePartten, $value);

            if(!$sortTypeResult)
            {
                $result = false;
            }

        }

        if(!$result)
        {
            $this->message = '排序必须是1234中数字';
            throw new RuleException('RuleSortTypeError');
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
