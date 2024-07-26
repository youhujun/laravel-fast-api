<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: lak 15931400746@163.com
 * @Date: 2023-08-14 18:02:09
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-15 11:06:38
 * @FilePath: \base.laravel.com\app\Rules\Public\CheckString.php
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class CheckString implements Rule
{
    protected $message;

    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     * 验证是否为字符串
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $result = true;

        if( isset($value) || !empty($value))
        {
            $checkStringResult = is_string($value);

            if(!$checkStringResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '必须是字符串';
            throw new RuleException('RuleCheckStringError',$attribute);
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
