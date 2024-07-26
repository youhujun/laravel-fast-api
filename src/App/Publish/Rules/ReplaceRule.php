<?php
/*
 * @Descripttion:自定验证规则替换模版
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-08 17:51:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 11:30:39
 * @FilePath: \app\Rules\ReplaceRule.php
 */

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class ReplaceRule implements Rule
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
            $replacePartten = '';

            $replaceResult = preg_match($replacePartten, $value);

            if(!$replaceResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = 'replaceMessage';
            throw new RuleException('RuleReplaceError',$attribute);
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
