<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: YouHuJun
 * @Date: 2022-02-08 22:55:47
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 16:06:09
 */

use Illuminate\Database\Eloquent\Model;

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

 return [
	'is_custom'=> env('YOUHUJUN_IS_CUSTOM', false),
 ];