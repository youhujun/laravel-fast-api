<?php
/*
 * @Descripttion:
 * @version:
 * @Author: Lak
 * @Date: 2023-08-10 10:13:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-15 11:08:14
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class CheckBetween implements Rule
{
    protected $message;

    //最小值
    protected $minLength = 0;

    //最大值
    protected $maxLength;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($minLength,$maxLength)
    {
        $this->minLength = $minLength;

        $this->maxLength = $maxLength;
    }

    /**
     * 验证是否符合长度
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
            $checkBetweenResult = mb_strlen($value);

            if ($checkBetweenResult < $this->minLength || $checkBetweenResult > $this->maxLength)
            {
                $result = false;

            }
        }

        if(!$result)
        {
            $this->message = '长度不符合';
            throw new RuleException('RuleCheckBetweenLengthError',$attribute);
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
        // return 'The validation error message.';
        return  $this->message;
    }
}
