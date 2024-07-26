<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 01:51:34
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 01:51:50
 * @FilePath: \config\custom\admin\code\admin_order_code.php
 */

return [
     //获取订单

    'GetOrderError'=>[ 'code'=>10000, 'msg'=>'获取订单失败','error'=>'GetOrderError' ],
    //获取订单产品

    'GetOrderGoodsError'=>[ 'code'=>10000, 'msg'=>'获取订单产品失败','error'=>'GetOrderGoodsError' ],
    //获取订单地址

    'GetOrderAddressError'=>[ 'code'=>10000, 'msg'=>'获取订单地址失败','error'=>'GetOrderAddressError' ],

    'UpdateOrderPropertyError'=>[ 'code'=>10000, 'msg'=>'更改订单属性失败','error'=>'UpdateOrderPropertyError' ],
    'UpdateOrderPropertyEventError'=>[ 'code'=>10000, 'msg'=>'更改订单属性事件失败','error'=>'UpdateOrderPropertyEventError' ],
];
