<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: lak 15931400746@163.com
 * @Date: 2023-08-11 17:22:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-02-15 11:09:36
 * @FilePath: \base.laravel.com\app\Rules\Public\FileType.php
 */

namespace App\Rules\Public;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Common\RuleException;

class FileType implements Rule
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
            $fileTypePartten = '/^[a-z]+$/';

            $fileTypeResult = preg_match($fileTypePartten, $value);

            if(!$fileTypeResult)
            {
                $result = false;
            }
        }

        if(!$result)
        {
            $this->message = '文件类型填写不正确,必须由一个或多个小写字母组成';
            throw new RuleException('RuleFileTypeError',$attribute);
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
