<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-14 15:52:50
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-14 16:07:33
 * @FilePath: \config\custom\public\code\common_map_code.php
 */

return [
    //腾讯地图获取位置失败
    'GetLocationRegionByH5TencentMapError' => ['code'=>10000,'msg'=>'腾讯地图H5获取位置失败!','error'=>'GetLocationRegionByH5TencentMapError'],
    'GetLocationRegionByH5TencentMapParamError' => ['code'=>10000,'msg'=>'腾讯地图经纬度参数缺失!!','error'=>'GetLocationRegionByH5TencentMapParamError'],
    'TencentMapNoKeyError' => ['code'=>10000,'msg'=>'腾讯地图的Key缺失!!','error'=>'TencentMapNoKeyError'],
    'TencentMapApiRegionUrlError' => ['code'=>10000,'msg'=>'腾讯地图逆地址解析地址缺失!','error'=>'TencentMapApiRegionUrlError'],
];
