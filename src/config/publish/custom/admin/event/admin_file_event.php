<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 02:07:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 02:11:43
 * @FilePath: \config\custom\admin\event\admin_file_event.php
 */

return [
    'UploadConfigFile'=> [ 'code' => 12110, 'info' => '上传配置文件','event'=>'UploadConfigFile'],
    'UploadFile'=> [ 'code' => 12120, 'info' => '上传文件','event'=>'UploadFile'],
    'UploadSinglePicture' => [ 'code' => 12130, 'info' => '上传单图','event'=>'UploadSinglePicture'],
    'UploadMultiplePicture' => [ 'code' => 12140, 'info' => '上传多图','event'=>'UploadMultiplePicture'],
    'UploadUserAvatar'=>[ 'code' => 12150, 'info' => '上传头像','event'=>'UploadUserAvatar'],
    'UploadResetPicture'=>[ 'code' => 12160, 'info' => '上传替换图片','event'=>'UploadResetPicture'],
];
