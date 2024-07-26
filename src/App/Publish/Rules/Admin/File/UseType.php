<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: lak 15931400746@163.com
 * @Date: 2023-08-11 17:22:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 11:27:27
 * @FilePath: \app\Rules\Admin\File\UseType.php
 */


namespace App\Rules\Admin\File;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class UseType implements Rule
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
            $useTypeArray = [10,20,30];

            $useTypeRResult = in_array($value,$useTypeArray);

            if(!$useTypeRResult)
            {
                $result = false;
            }

        }

        if(!$result)
        {
            $this->message = 'use_type的值不正确';
            throw new RuleException('RuleUseTypeError',$attribute);
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
