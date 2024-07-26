<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-09 13:44:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-15 11:06:03
 * @FilePath: \base.laravel.com\app\Rules\Public\Numeric.php
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class Numeric implements Rule
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

        if(isset($value) || !empty($value))
        {

            $checkIsArray = is_array($value);

            if(!$checkIsArray)
            {
                $numericPartten = '/^[\d.]+$/';

                $numericResult = preg_match($numericPartten, $value);

                if($numericResult)
                {
                    $result = true;
                }
            }
        }

        if(!$result)
        {
            $this->message = '必须是数字类型';
            throw new RuleException('RuleNumericError',$attribute);
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
