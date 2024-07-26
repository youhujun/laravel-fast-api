<?php
/*
 * @Descripttion: 自定义助手函数
 * @Author: YouHuJun
 * @Date: 2020-02-20 11:25:39
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 12:06:36
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

 if(!function_exists('p'))
 {
     /**
      * @description: 打印函数
      * @param {mixed}
      * @return: void
      */
     function p($param):void
     {
         echo "<pre>";
         print_r($param);
         echo "</pre>";
     }
 }


if(!function_exists('plog'))
{
    /**
     * 记录日志 主要用于手动记录事件日志
     *
     * @param [type] $data 打印数据
     * @param string $type 文件名(日志文件名)
     * @return void
     */
    function plog($data, $type = 'common')
    {
        $dir = storage_path('custom'. DIRECTORY_SEPARATOR.date("Y-m-d") ) . DIRECTORY_SEPARATOR;
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $file = $dir . $type . ".log";
        $content = date("H:i:s") . "     " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\r\n";
        return file_put_contents($file, $content, FILE_APPEND);
    }

}

 if(!function_exists('f'))
 {
     /**
      * @description: 过滤字符串中的标签
      * @param {string}
      * @return: void
      */
     function f($param,$type = 0)
     {
         if(is_array($param))
         {
              foreach($param as $key => $value)
              {
                  if(is_array($value))
                  {
                      $value = f($value);
                  }
                  else
                  {
					if(!$type)
					{
						$value = htmlspecialchars($value);
					}
					else
					{
						$value = strip_tags($value);
					}

                  }
              }
         }
         else
         {
            if(!$type)
			{
				$value = htmlspecialchars($value);
			}
			else
			{
				$value = strip_tags($value);
			}
         }
         return $param;
     }
 }

 if(!function_exists('code'))
 {
     /**
      * @description: 请求返回
      * @param {array} $code ,配置文件code,定义
      * @param {array} $add,需要手动添加的数据
      * @return:
      */
     function code($code=[],$add=[])
     {
         $resArr = [];
         if(is_null($code)&&is_null($add))
         {
            $resArr = [];
         }
         else if(is_null($code)&&!is_null($add))
         {
            $resArr = $add;
         }
         else if(!is_null($code)&&is_null($add))
         {
            $resArr = $code;
         }
         else
         {
            $resArr = array_merge($code,$add);
         }
        return  $resArr;
     }
 }


if(!function_exists('convertToString'))
{
    /**
     * 转化数组或者对象数据为字符串
     *
     * @param [type] $data
     * @return void
     */
    function convertToString($data)
    {
        if($data instanceof Model)
        {
            $data = \serialize($data);
        }
        else
        {
            if(\is_array($data)||\is_object($data))
            {
                $data = \json_encode($data);
            }
        }

        return $data;
    }
}

 if(!function_exists('is_serialized'))
{
    /**
     * 检测字符串是否是序列化的
     *
     * @param [type] $data
     * @return boolean
     */
    function is_serialized( $data )
    {
        $result = 0;
        $data = trim( $data );
        if ( 'N;' == $data )
        $result = 1;
        if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
        $result = 0;
        switch ( $badions[1] )
        {
            case 'a' :
            case 'O' :
            case 's' :
                if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                $result = 1;
            break;
            case 'b' :
            case 'i' :
            case 'd' :
                if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                $result = 1;
            break;
        }
        return $result;
    }
}

/**
 * 请求处理 ++++++++++++++++++++++++++++++++++++++++++
 */

if(!function_exists('httpGet'))
{
   /**
    * @description: 发送get请求
    * @param {uri} url是请求地址
    * @return: mixed 请求的结果
    */
   function httpGet($url)
   {
       $curl = curl_init();
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
       curl_setopt($curl, CURLOPT_TIMEOUT, 10 );
       curl_setopt($curl, CURLOPT_URL, $url );
       $res = curl_exec($curl);
       curl_close($curl);
       return $res;
   }
}
if(!function_exists('httpPost'))
{
      /**
    *  function  发起curl的post请求
    *
    * @param [string] $url 地址
    * @param array $headers 请求头数组
    $headers = ['X-TOKEN:'.$this->token,'X-VERSION:1.1.3','Content-Type:application/json','charset=utf-8'];
    * @param [请求数据] $data
    * @return //返回结果
    */
    function httpPost($url, $headers=[],$data=null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        //设置请求头
        if(is_array($headers) && count($headers) > 0)
        {
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        if(!empty($data)){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}
/**
 * 请求处理结束--------------------------------------------------

 */

/**
 * 协助处理数组++++++++++++++++++++++++++++
 */

if (!function_exists('array_level')) {
    /**
     * [array_level 计算数组的维度 需要结合total函数]
     * @param  Array  $arr [需要计算的数组]
     * @return [int]      [返回数组的维度]
     */
    function array_level(array $arr)
    {
        $al = [0];
        total($arr, $al);
        return max($al);
    }
}
if (!function_exists('total')) {
    /**
     * [total 辅助 array_level计算数组维度 辅助array_level函数]
     * @param  [array]  $arr   [传入的数组]
     * @param  [array引用参数]  &$al   [传入的值]
     * @param  integer $level [统计的数组维度]
     * @return [void]         [无返回值]
     */
    function total($arr, &$al, $level = 0)
    {
        if (is_array($arr)) {

            $level++;

            $al[] = $level;

            foreach ($arr as $v) {
                total($v, $al, $level);
            }
        }
    }
}

if (!function_exists('toArray'))
{
    /**
     * @param [type] $array
     * @return void
     */
    function toArray($array)
    {
        if(is_array($array))
        {
            foreach($array as $k => &$v)
            {
                 $v =  array($v);
            }
        }

        return $array;
    }
}

/**
 * 协助处理数组结束--------------------------
 */


/**
 * 处理时间开始
 */

if(!function_exists('showTime'))
{
    /**
     * Undocumented function 时间戳转字符串
     *
     * @param [int] $time 时间戳
     * @param boolean $bool 布尔 如果为真带时分秒
     * @return string
     */
    function showTime($time,$bool = false)
    {
       if($bool)
       {
           return date('Y-m-d H:i:s',$time);
       }
       else
       {
           return date('Y-m-d',$time);
       }

    }
}

/**
 * 处理时间结束
 */



if(!function_exists('em'))
{
    /**
     * Undocumented function
     *
     * @param \Throwable $e 捕获异常
     * @param boolean $log 是否写入异常日志
     * @param boolean $notification 是否发送通知
     * @return void
     */
    function em(\Throwable $e,$log = false,$notification = false)
    {
        $time = date('Y-m-d H:i:s',time());
        $msg = "时间:{$time}";
        $msg .= "\r\n异常消息：".($e->message?$e->message:$e->getMessage());
        $msg .= "\r\n错误码:".$e->getCode();
        $msg .= "\r\n文件：".$e->getFile();
        $msg .= "\r\n行号：".$e->getLine();
        $msg .= "\r\n参数:".json_encode(['params' => request()->all()]);

        if($log)
        {
            \file_put_contents(\storage_path()."/logs/exception.log","{$msg}\r\n",\FILE_APPEND);
        }

        if($notification)
        {
            if(env('YouHuJun_Publish'))
            {
                 Notification::route('mail', config('mail.exception.email'))
                 ->notify(new \App\Notifications\SendExceptionMessageNoification($msg));
            }
        }

        return $msg;
    }
}

if(!function_exists('checkId'))
{
    /**
     * 检测是否为id
     *
     * @param [type] $id
     * @return void
     */
    function checkId($id)
    {
        $partten = "/^[0-9]+$/";

        $regexResult = \preg_match($partten,$id);

        if(!$regexResult)
        {
            $id = 0;
        }

        return $id;
    }
}


if(!function_exists('price'))
 {
      /**
      * Undocumented function 价格存储及显示
      *
      * @param [string|number] $price 价格
      *
      * @return string 处理完带两位小数点的价格
      */
     function price($price)
     {
        return number_format($price,'2','.','');
     }
 }
