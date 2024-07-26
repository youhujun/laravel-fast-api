<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-03-26 11:01:07
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 01:13:01
 */

namespace App\Exceptions\Phone;

use Exception;

class CommonException extends Exception
{
    //错误码
    public $errorKey;

    //日志存储消息
    public $message;

    //发送邮件通知的错误码  可以在这里定义
    public $emailArray;


    /**
     * Class constructor.
     */
    function __construct($errorKey = null)
    {
        if($errorKey)
        {
            $this->errorKey = $errorKey;

            $message = config("phone_code.{$this->errorKey}.msg");

            if(!$message)
            {
                $this->errorKey = 'CodeError';
                $this->message = "错误码不存";
            }
        }
        else
        {
             $this->errorKey = 'ServerError';
             $this->message = "服务器异常";
        }

        $this->emailArray = config('phone_code.EmailArray');
    }

    /**
     * 发送报告
     *
     * @return void
     */
	public function report()
	{
        if(count($this->emailArray) && \in_array( $this->errorKey,$this->emailArray))
        {
            em($this,true,true);
        }
        else
        {
            em($this,true);
        }

	}

    /**
     * 渲染返回
     *
     * @return void
     */
	public function render()
	{
		return code(config("phone_code.{$this->errorKey}"));
	}
}
