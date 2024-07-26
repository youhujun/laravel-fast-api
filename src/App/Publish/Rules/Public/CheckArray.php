<?php
/*
 * @Descripttion:
 * @version:
 * @Author: Lak
 * @Date: 2023-08-09 16:31:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-15 11:02:38
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class CheckArray implements Rule
{
    protected $message;

    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     * 验证是否为数组
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = true;

        if( isset($value) || !empty($value))
        {
            $checkArrayResult = is_array($value);

            if(!$checkArrayResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '必须是数组';
            throw new RuleException('RuleCheckArrayError',$attribute);
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
