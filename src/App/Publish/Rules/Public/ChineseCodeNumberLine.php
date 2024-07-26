<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-10 14:16:39
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-15 11:09:13
 * @FilePath: \base.laravel.com\app\Rules\Public\ChineseCodeNumberLine.php
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class ChineseCodeNumberLine implements Rule
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
            $chineseCodeNumberLinePartten = '/^([\x{4e00}-\x{9fa5}]|[a-zA-Z0-9_-])+$/u';

            $chineseCodeNumberLineResult = preg_match($chineseCodeNumberLinePartten, $value);

            if(!$chineseCodeNumberLineResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '必须由中文字符字母数字下划线组成';
            throw new RuleException('RuleChineseCodeNumberLineError',$attribute);
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
