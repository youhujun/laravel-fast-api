<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-09 14:15:32
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-18 10:22:24
 * @FilePath: \app\Exceptions\Common\RuleException.php
 */

namespace App\Exceptions\Common;

use Exception;

class RuleException extends Exception
{
    //验证规则的属性值
    public $attribute;
    //错误码
    public $errorKey;

    //日志存储消息
    public $message;

    //发送邮件通知的错误码  可以在这里定义
    public $emailArray;

     /**
     * Class constructor.
     */
    function __construct($errorKey = null,$attribute = null)
    {
        if($attribute)
        {
            $this->attribute = $attribute;
        }

        if($errorKey)
        {
            $this->errorKey = $errorKey;
            $this->message = config("rule_code.{$this->errorKey}.msg")."--{$this->attribute}";
        }
        else
        {
             $this->errorKey = 'serverError';
             $this->message = "服务器异常";
        }

        $this->emailArray = config('rule_code.EmailArray');
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
		return code(config("rule_code.{$this->errorKey}"),['attribute'=>$this->attribute]);
	}
}
