<?php
/*
 * @Descripttion: 自定义验证规则错误码配置
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-09 10:00:05
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 11:20:30
 * @FilePath: \config\custom\public\rule\rule_code.php
 */

 //|--业务公共错误码
$publicCodeArray = [
    'RuleIdNumberError' => [ 'code'=>-10000, 'msg'=>'身份证号不正确' ],
    'RulePhoneError' => [ 'code'=>-10000, 'msg'=>'手机号不正确' ],
];

//|--系统逻辑公共错误码
$commonCodeArray = [

];

//|--后台公共错误码
$adminCodeArray = [

];

//|--手机公共错误码
$phoneCodeArray = [
    'RulePhoneIsRegister' => [ 'code'=>-10000, 'msg'=>'该手机号已经被注册' ],
];

$totalCodeArray =  [

    //发送异常邮件通知定义
    'EmailArray' =>[
        //'serverError',
    ],

    /**
     * ******************************common公共模块***************************************
     * ******************************common公共模块***************************************
     * ******************************common公共模块***************************************
     * ******************************common公共模块***************************************
     * ******************************common公共模块***************************************
     * ******************************common公共模块***************************************
     * ******************************common公共模块***************************************
     */
    'RuleRequiredError'=>[ 'code'=>-10000, 'msg'=>'该数据不能为空,至少包含一个非空白字符' ],
    'RuleFileTypeError'=>[ 'code'=>-10000, 'msg'=>'文件类型填写不正确,必须由一个或多个小写字母组成' ],
    'RuleNumericError'=>[ 'code'=>-10000, 'msg'=>'必须是数字类型' ],
    'RuleCheckArrayError'=>[ 'code'=>-10000, 'msg'=>'必须是数组' ],
    'RuleCheckStringError'=>[ 'code'=>-10000, 'msg'=>'必须是字符串' ],
    'RuleFileActionError'=>[ 'code'=>-10000, 'msg'=>'文件执行动作不正确' ],
    'RuleCheckUniqueError'=>[ 'code'=>-10000, 'msg'=>'数据唯一性校验失败' ],
    'RuleCheckBetweenLengthError'=>[ 'code'=>-10000, 'msg'=>'长度不符合' ],
    'RuleTimeFormatError'=>[ 'code'=>-10000, 'msg'=>'时间格式不正确' ],
    'RuleChineseError'=>[ 'code'=>-10000, 'msg'=>'必须由一个或多个汉字组成' ],
    'RuleChineseCodeNumberLineError'=>[ 'code'=>-10000, 'msg'=>'必须由中文字符字母数字下划线组成' ],
    'RuleSolarBirthdayTimeError'=>[ 'code'=>-10000, 'msg'=>'出生日期格式错误' ],
    'RuleCheckSexError'=>[ 'code'=>-10000, 'msg'=>'性别选择错误' ],
    'RuleCheckAddressError'=>[ 'code'=>-10000, 'msg'=>'地址格式错误' ],
    'RulePhoneError'=>[ 'code'=>-10000, 'msg'=>'手机号格式错误' ],
    'RuleTreeDeepError'=>[ 'code'=>-10000, 'msg'=>'deep的值必须大于0' ],
    'RuleidNumberPatternError'=>[ 'code'=>-10000, 'msg'=>'身份号格式错误' ],

    'RuleCheckLetterNumberUnderLineError'=>[ 'code'=>-10000, 'msg'=>'格式必须由大小写字母、数字和下划线组成' ],

    //后台
    /*****************************后台公共************************************/
    /*****************************后台公共************************************/
    /*****************************后台公共************************************/
    'RuleSortTypeError' => [ 'code'=>-10000, 'msg'=>'登录账号非法!' ],

    //后台登录
    'RuleLoginAccountError' => [ 'code'=>-10000, 'msg'=>'登录账号非法!','error'=>'RuleLoginAccountError' ],
    'RuleAdminPasswordError'=>[ 'code'=>-10000, 'msg'=>'密码必须由数字+字母6-10位组成','error'=>'RuleAdminPasswordError' ],

    //|--系统模块
    //|--系统模块
    //
    'RuleUseTypeError'=>[ 'code'=>-10000, 'msg'=>'use_type的值不正确' ],
    //|--|--系统配置
    'RuleSystemConfigItemTypeError'=>[ 'code'=>-10000, 'msg'=>'item_type的值不正确' ],

    //|--用户管管理
    //后台用户专用密码验证


];

$errorCodeArray = array_merge(
    $publicCodeArray,
    $commonCodeArray,
    $adminCodeArray,
    $phoneCodeArray,
    $totalCodeArray
);

 return $errorCodeArray;
