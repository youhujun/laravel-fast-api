<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-08 17:49:55
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 21:07:13
 * @FilePath: \app\Rules\Public\Required.php
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

/**
 * 必须有数据
 */
class Required implements Rule
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
        $result = false;

        //判断数值不为空的情况
        if( isset($value) || !empty($value))
        {
            //判断是否是数组
            $checkIsArray = is_array($value);

            if($checkIsArray)
            {
                $result = true;
            }
            else
            {
                //判断字符串不能为空
                $requiredPartten = "/[\S]+/";

                $requiredResult = preg_match($requiredPartten, $value);

                if ($requiredResult)
                {
                    $result = true;
                }
            }
        }

        if(!$result)
        {
            $this->message = '该数据不能为空,至少包含一个非空白字符';
            throw new RuleException('RuleRequiredError',$attribute);
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
