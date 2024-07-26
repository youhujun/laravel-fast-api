<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: lak 15931400746@163.com
 * @Date: 2023-08-14 17:57:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 11:30:10
 * @FilePath: \app\Rules\Public\LetterNumberUnderLine.php
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class LetterNumberUnderLine implements Rule
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

            $CheckLetterNumberUnderLine = '/^|[a-zA-Z0-9_]+$/u';

            $CheckLetterNumberUnderLineVerify = preg_match($CheckLetterNumberUnderLine, $value);

            if (!$CheckLetterNumberUnderLineVerify)
            {

                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '格式必须由大小写字母、数字和下划线组成';
            throw new RuleException('RuleCheckLetterNumberUnderLineError', $attribute);
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
