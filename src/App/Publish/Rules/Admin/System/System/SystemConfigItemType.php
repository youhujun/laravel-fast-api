<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-10 15:51:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-28 15:19:16
 * @FilePath: \api.laravel.com_LV9\app\Rules\Admin\System\System\SystemConfigItemType.php
 */

namespace App\Rules\Admin\System\System;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class SystemConfigItemType implements Rule
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
            $systemConfigItemTypeArray = [10,20,30,40];

            $systemConfigItemTypeRResult = in_array($value,$systemConfigItemTypeArray);

            if(!$systemConfigItemTypeRResult)
            {
                $result = false;
            }

        }

        if(!$result)
        {
            $this->message = 'item_type的值不正确';
            throw new RuleException('RuleSystemConfigItemTypeError',$attribute);
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
