<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 02:07:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 02:12:15
 * @FilePath: \config\custom\admin\event\admin_goods_event.php
 */

return [
    'AddGoods' => [ 'code' => 10000, 'info' => '添加产品' ],
    'UpdateGoods' => [ 'code' => 10000, 'info' => '修改产品' ],
    'DeleteGoods' => [ 'code' => 10000, 'info' => '删除产品' ],
    'restoreGoods' => [ 'code' => 10000, 'info' => '复用产品' ],
    'multipleDeleteGoods' => [ 'code' => 10000, 'info' => '批量删除产品' ],
    'multipleRestoreGoods' => [ 'code' => 10000, 'info' => '批量复用产品' ],
    'checkGoods' => [ 'code' => 10000, 'info' => '审核产品' ],
    'showGoods' => [ 'code' => 10000, 'info' => '上架产品' ],
    'hiddenGoods' => [ 'code' => 10000, 'info' => '下架产品' ],
    'multipleShowGoods' => [ 'code' => 10000, 'info' => '批量上架产品' ],
    'multipleHiddenGoods' => [ 'code' => 10000, 'info' => '批量下架产品' ],
    //更新产品状态
    'UpdateGoodsType' => [ 'code' => 10000, 'info' => '更新产品状态' ],
    //更新产品属性
    'UpdateGoodsProperty' => [ 'code' => 10000, 'info' => '更新产品属性' ],
        //|--|++产品细节
        //|--|++产品主图
        //添加善品主图
        'AddGoodsMainPicture'=> [ 'code' => 10000, 'info' => '添加产品主图' ],
        //删除产品主图
        'DeleteGoodsMainPicture'=> [ 'code' => 10000, 'info' => '删除产品主图' ],
        //|--|++产品分类
        'AddGoodsClassification' => [ 'code' => 10000, 'info' => '添加产品分类' ],
        'DeleteGoodsClassification' => [ 'code' => 10000, 'info' => '删除产品分类' ],
        //|--|++产品地区
        'AddGoodsRegion' => [ 'code' => 10000, 'info' => '添加产品地区' ],
        'DeleteGoodsRegion' => [ 'code' => 10000, 'info' => '删除产品地区' ],
        //|--|++产品详情
        'UpdateGoodsIntroduction'=>[ 'code' => 10000, 'info' => '修改产品简介' ],
        'UpdateGoodsDescription'=>[ 'code' => 10000, 'info' => '修改产品描述' ],
    //产品统计
    'UpdateGoodsTotalProperty' =>[ 'code' => 10000, 'info' => '修改产品统计' ],
];
