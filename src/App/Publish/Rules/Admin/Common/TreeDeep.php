<?php
/*
 * @Descripttion:
 * @version:
 * @Author: Lak
 * @Date: 2023-08-10 18:56:03
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 11:27:05
 */

namespace App\Rules\Admin\Common;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class TreeDeep implements Rule
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

        if($value == 0)
        {
            $result = false;
        }

        if(!$result)
        {
            $this->message = 'deep的值必须大于0';
            throw new RuleException('RuleTreeDeepError',$attribute);
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
