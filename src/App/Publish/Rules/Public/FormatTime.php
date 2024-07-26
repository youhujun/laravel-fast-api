<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-12 18:01:37
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-15 11:10:00
 * @FilePath: \base.laravel.com\app\Rules\Public\FormatTime.php
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class FormatTime implements Rule
{
    protected $message;


    /**
     *
     *
     * @var [type] 10 Y-m-d 20 Y-m-d H:i:s
     */
    protected $timeType;

    public function __construct($timeType = 10)
    {
        $this->timeType = $timeType;
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

        if(isset($value))
        {

            if($this->timeType == 10)
            {
                $timePartten = '/^\d{4}-\d{2}-\d{2}$/';
            }

            if($this->timeType == 20)
            {
                $timePartten =  '/^\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2}$/';
            }

            $timeResult = preg_match($timePartten, $value);

            if(!$timeResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '时间格式不正确';
            throw new RuleException('RuleTimeFormatError',$attribute);
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
