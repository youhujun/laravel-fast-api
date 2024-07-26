<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 01:51:34
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 01:51:50
 * @FilePath: \config\custom\admin\code\admin_goods_code.php
 */

return [
        'resetGoodsStatusError' => ['code'=>10000, 'msg'=>'重置产品审核上架状态失败'],
     //获取产品列表

    'getGoodsError'=>[ 'code'=>10000, 'msg'=>'获取产品失败' ],
     //添加产品

    'AddGoodsError'=>[ 'code'=>10000, 'msg'=>'添加产品失败' ],
    'AddGoodsEventError'=>[ 'code'=>10000, 'msg'=>'添加产品事件失败' ],
    //|++添加产品事件
        //产品分类

        'AddGoodsClassificationError'=> [ 'code'=>10000, 'msg'=>'添加产品分类失败' ],
        //产品主图

        'AddGoodsMainPictureError' => [ 'code'=>10000, 'msg'=>'添加产品主图失败' ],
         //产品地区

        'AddGoodsRegionError' => [ 'code'=>10000, 'msg'=>'添加产品地区失败'],
        //产品详情

        'AddGoodsInfoError' => [ 'code'=>10000, 'msg'=>'添加产品详情失败'],
        //产品统计

        'AddGoodsTotalError' => [ 'code'=>10000, 'msg'=>'添加产品统计失败'],

    //更新产品类型状态

    'UpdateGoodsTypeError'=>[ 'code'=>10000, 'msg'=>'更新产品类型状态失败'],
    'UpdateGoodsTypeEventError'=>[ 'code'=>10000, 'msg'=>'更新产品类型状态失败'],

    //|--|++产品审核
    //获取产品申请

    'getGoodsApplyError' => [ 'code'=> 10000, 'msg'=>'获取产品申请失败'],

    //获取待更新产品

    'getUpdateGoodsError'=>[ 'code'=>10000, 'msg'=>'获取待更新产品失败' ],
     //更新产品

    'UpdateGoodsError'=>[ 'code'=>10000, 'msg'=>'更新产品失败' ],
    'UpdateGoodsInfoError'=>[ 'code'=>10000, 'msg'=>'更新产品详情失败' ],
    'UpdateGoodsClassificationError'=>[ 'code'=>10000, 'msg'=>'更新产品分类失败' ],
    'UpdateGoodsMainPictureError'=>[ 'code'=>10000, 'msg'=>'更新产品主图失败' ],
    'UpdateGoodsApplyError'=>[ 'code'=>10000, 'msg'=>'更新产品申请失败' ],
    'UpdateGoodsEventError'=>[ 'code'=>10000, 'msg'=>'更新产品事件失败' ],
    //删除产品

    'DeleteGoodsError'=>[ 'code'=>10000, 'msg'=>'删除产品失败' ],
    'DeleteGoodsEventError'=>[ 'code'=>10000, 'msg'=>'删除产品事件失败' ],
    'restoreGoodsSuccess'=>[ 'code'=>0, 'msg'=>'复用产品成功' ],
    'restoreGoodsError'=>[ 'code'=>10000, 'msg'=>'复用产品失败' ],
    'restoreGoodsEventError'=>[ 'code'=>10000, 'msg'=>'复用产品事件失败' ],
    //批量删除复用

    'multipleDeleteGoodsError'=>[ 'code'=>10000, 'msg'=>'批量删除产品失败' ],
    'multipleDeleteGoodsEventError'=>[ 'code'=>10000, 'msg'=>'批量删除产品事件失败' ],
    'multipleRestoreGoodsSuccess'=>[ 'code'=>0, 'msg'=>'批量复用产品成功' ],
    'multipleRestoreGoodsError'=>[ 'code'=>10000, 'msg'=>'批量复用产品失败' ],
    'multipleRestoreGoodsEventError'=>[ 'code'=>10000, 'msg'=>'批量复用产品事件失败' ],
     //审核产品

    'checkGoodsError'=>[ 'code'=>10000, 'msg'=>'审核产品失败' ],
    'checkGoodsEventError'=>[ 'code'=>10000, 'msg'=>'审核产品事件失败' ],
    //|--|++审核产品事件

    'checkGoodsApplyError'=>[ 'code'=>0, 'msg'=>'更改产品审核记录失败' ],
        //|--|++产品主图

        'getGoodsMainPictureError'=>[ 'code'=>10000, 'msg'=>'获取产品主图失败' ],
        //添加产品主图

        'AddGoodsMainPictureError' =>[ 'code'=>10000, 'msg'=>'添加产品主图失败' ],
        'AddGoodsMainPictureEventError' =>[ 'code'=>10000, 'msg'=>'添加产品主图事件失败' ],
        //删除产品主图

        'DeleteGoodsMainPictureError' => [ 'code'=>10000, 'msg'=>'删除产品主图失败' ],
        'DeleteGoodsMainPictureEventError' => [ 'code'=>10000, 'msg'=>'删除产品主图事件失败' ],
        //|--|++产品分类

        'getGoodsClassificationError'=>[ 'code'=>10000, 'msg'=>'获取产品分类失败' ],
        //添加产品分类

        'AddGoodsClassificationError'=>[ 'code'=>10000, 'msg'=>'添加产品分类失败' ],
        'AddGoodsClassificationEventError'=>[ 'code'=>10000, 'msg'=>'添加产品分类事件失败' ],
        //删除产品分类

        'DeleteGoodsClassificationError'=>[ 'code'=>10000, 'msg'=>'删除产品分类失败' ],
        'DeleteGoodsClassificationEventError'=>[ 'code'=>10000, 'msg'=>'删除产品分类事件失败' ],
        //|--|++产品详情

        'getGoodsInfoError'=>[ 'code'=>10000, 'msg'=>'获取产品详情失败' ],
         //修改产品简介

         'UpdateGoodsIntroductionError'=>[ 'code'=>10000, 'msg'=>'修改产品简介失败' ],
         'UpdateGoodsIntroductionEventError'=>[ 'code'=>10000, 'msg'=>'修改产品简介失败' ],
         //修改产品描述

         'UpdateGoodsDescriptionError'=>[ 'code'=>10000, 'msg'=>'修改产品描述失败' ],
         'UpdateGoodsDescriptionEventError'=>[ 'code'=>10000, 'msg'=>'修改产品描述失败' ],
        //|--|++产品地区

        'getGoodsRegionError'=>[ 'code'=>10000, 'msg'=>'获取产品地区失败' ],
        //添加产品地区

        'AddGoodsRegionError'=>[ 'code'=>10000, 'msg'=>'添加产品地区失败' ],
        'AddGoodsRegionEventError'=>[ 'code'=>10000, 'msg'=>'添加产品地区事件失败' ],
        //删除产品地区

        'DeleteGoodsRegionError'=>[ 'code'=>10000, 'msg'=>'删除产品地区失败' ],
        'DeleteGoodsRegionEventError'=>[ 'code'=>10000, 'msg'=>'删除产品地区事件失败' ],
     //上架/下架产品

    'showGoodsError'=>[ 'code'=>10000, 'msg'=>'上架产品失败' ],
    'showGoodsEventError'=>[ 'code'=>10000, 'msg'=>'上架产品事件失败' ],

    'hiddenGoodsError'=>[ 'code'=>10000, 'msg'=>'下架产品失败' ],
    'hiddenGoodsEventError'=>[ 'code'=>10000, 'msg'=>'下架产品事件失败' ],
    //批量上架/下架产品

    'multipleShowGoodsError'=>[ 'code'=>10000, 'msg'=>'批量上架产品失败' ],
    'multipleShowGoodsEventError'=>[ 'code'=>10000, 'msg'=>'批量上架产品事件失败' ],

    'multipleHiddenGoodsError'=>[ 'code'=>10000, 'msg'=>'批量下架产品失败' ],
    'multipleHiddenGoodsEventError'=>[ 'code'=>10000, 'msg'=>'批量下架产品事件失败' ],

    //更改产品属性

    'UpdateGoodsPropertyError'=>[ 'code'=>10000, 'msg'=>'更改产品属性失败!' ],
    'UpdateGoodsPropertyEventError'=>[ 'code'=>10000, 'msg'=>'更改产品属性事件失败!' ],

    //|--|++产品统计
    //获取产品统计

    'getGoodsTotalError' => [ 'code'=>10000, 'msg'=>'获取产品统计失败!' ],
    //修改产品属性
    'UpdateGoodsTotalPropertyError'=>[ 'code'=>10000, 'msg'=>'修改产品属性失败!' ],
    'UpdateGoodsTotalPropertyEventError'=>[ 'code'=>10000, 'msg'=>'修改产品属性事件失败!' ],
];
