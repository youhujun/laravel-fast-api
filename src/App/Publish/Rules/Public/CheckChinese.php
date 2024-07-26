<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-10 13:57:22
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-15 11:08:31
 * @FilePath: \base.laravel.com\app\Rules\Public\CheckChinese.php
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class CheckChinese implements Rule
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

        if( isset($value) || !empty($value))
        {
            $chinesePartten = '/^[\x{4e00}-\x{9fa5}]+$/u';

            $chineseResult = preg_match($chinesePartten, $value);

            if(!$chineseResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '必须由一个或多个汉字组成';
            throw new RuleException('RuleChineseError',$attribute);
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
