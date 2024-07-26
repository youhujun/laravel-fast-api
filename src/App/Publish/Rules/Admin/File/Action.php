<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-09 21:58:49
 * @LastEditors: Lak
 * @LastEditTime: 2023-08-11 16:34:49
 * @FilePath: \api.laravel.com_LV9\app\Rules\Admin\File\Action.php
 */

namespace App\Rules\Admin\File;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class Action implements Rule
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

        if (isset($value) || !empty($value))
        {

            $actionPartten = '/^[a-zA-Z]+$/';

            $actionResult = preg_match($actionPartten, $value);

            if (!$actionResult)
            {

                $result = false;

            }
        }

        if(!$result)
        {
            $this->message = '文件执行动作不正确';
            throw new RuleException('RuleFileActionError', $attribute);
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
