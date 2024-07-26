<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 02:15:28
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 12:49:43
 * @FilePath: \config\custom\admin\event\admin_picture_event.php
 */

return [
     //|--|--我的相册
    'AddAlbum' => [ 'code' => 10000, 'info' => '添加相册','error'=>'AddAlbum','event'=>'AddAlbum' ],
    'UpdateAlbum' => [ 'code' => 10000, 'info' => '修改相册','error'=>'UpdateAlbum','event'=>'UpdateAlbum' ],
    'DeleteAlbum' => [ 'code' => 10000, 'info' => '删除相册','error'=>'DeleteAlbum','event'=>'DeleteAlbum' ],
    'MoveDeleteAlbumPicture' => [ 'code' => 10000, 'info' => '移动删除相册的图片','error'=>'MoveDeleteAlbumPicture','event'=>'MoveDeleteAlbumPicture' ],
    //|--|--|--图片处理
    'SetCover' => [ 'code' => 10000, 'info' => '设置封面','error'=>'SetCover','event'=>'SetCover' ],
    'MoveAlbum' => [ 'code' => 10000, 'info' => '移动相册','error'=>'MoveAlbum','event'=>'MoveAlbum' ],
    'MoveMultipleAlbum' => [ 'code' => 10000, 'info' => '批量移动相册','event'=>'MoveMultipleAlbum' ],
    'DeletePicture' => [ 'code' => 10000, 'info' => '删除图片','event'=>'DeletePicture' ],
    'DeleteMultiplePicture' => [ 'code' => 10000, 'info' => '批量删除图片','event'=>'DeleteMultiplePicture' ],
    'UpdatePictureName' => [ 'code' => 10000, 'info' => '更新图片名称','event'=>'UpdatePictureName' ],
];
