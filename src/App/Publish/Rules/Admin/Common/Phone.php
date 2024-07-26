<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-28 08:06:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-09-15 11:28:52
 * @FilePath: \api.laravel.com_LV9\app\Rules\Admin\Common\Phone.php
 */
/*
 * @Descripttion:
 * @version:
 * @Author: Lak
 * @Date: 2023-08-14 10:21:46
 * @LastEditors: Lak
 * @LastEditTime: 2023-08-14 10:22:02
 */

namespace App\Rules\Admin\Common;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class Phone implements Rule
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

            $phonePartten = '/^(13[0-9]|14[5|7]|15[0|1|2|3|4|5|6|7|8|9]|18[0|1|2|3|5|6|7|8|9])\d{8}$/';

            $phoneResult = preg_match($phonePartten, $value);

            if (!$phoneResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '手机号格式错误';
            throw new RuleException('RulePhoneError', $attribute);
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
        return $this->message;
    }
}
