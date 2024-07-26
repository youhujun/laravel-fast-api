<?php
/*
 * @Descripttion:
 * @version:
 * @Author: Lak
 * @Date: 2023-08-08 09:16:03
 * @LastEditors: Lak
 * @LastEditTime: 2023-08-11 10:13:19
 */

namespace App\Rules\Phone;

use App\Exceptions\Common\RuleException;

use Illuminate\Contracts\Validation\Rule;

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
            $this->message = '手机号不正确';
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
