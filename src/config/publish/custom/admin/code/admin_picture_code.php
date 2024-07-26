<?php

return [

     //|--|--|--我的相册

        'GetAlbumError'=>[ 'code'=>10000, 'msg'=>'获取相册失败','error'=>'GetAlbumError' ],

        'AddAlbumError'=>[ 'code'=>10000, 'msg'=>'添加相册失败','error'=>'AddAlbumError' ],
        'AddAlbumEventError'=>[ 'code'=>10000, 'msg'=>'添加相册事件失败','error'=>'AddAlbumEventError' ],

        'UpdateAlbumError'=>[ 'code'=>10000, 'msg'=>'更新相册失败','error'=>'UpdateAlbumError' ],
        'UpdateAlbumEventError'=>[ 'code'=>10000, 'msg'=>'更新相册事件失败','error'=>'UpdateAlbumEventError' ],

        'DeleteAlbumError'=>[ 'code'=>10000, 'msg'=>'删除相册失败','error'=>'DeleteAlbumError' ],
        'ThisAlbumIsSystemError'=>[ 'code'=>10000, 'msg'=>'系统相册不能删除','error'=>'ThisAlbumIsSystemError' ],
        'ThisSystemAlbumNotExistsError'=>[ 'code'=>10000, 'msg'=>'未找到系统默认相册','error'=>'ThisSystemAlbumNotExistsError' ],
        'ThisAlbumAdminNotExistsError'=>[ 'code'=>10000, 'msg'=>'未找到图片管理员','error'=>'ThisAlbumAdminNotExistsError' ],
        'ThisAlbumUserNotExistsError'=>[ 'code'=>10000, 'msg'=>'未找到图片用户','error'=>'ThisAlbumUserNotExistsError' ],
        'DeleteAlbumEventError'=>[ 'code'=>10000, 'msg'=>'删除相册事件失败','error'=>'DeleteAlbumEventError' ],
        'DeleteAlbumMovePictureError'=>[ 'code'=>10000, 'msg'=>'删除相册移动图片失败','error'=>'DeleteAlbumMovePictureError' ],
        'DeleteAlbumMovePictureEventError'=>[ 'code'=>10000, 'msg'=>'删除相册移动图片事件失败','error'=>'DeleteAlbumMovePictureEventError' ],

        'GetAlbumPictureError'=>[ 'code'=>10000, 'msg'=>'获图片失败','error'=>'GetAlbumPictureError' ],

        //相册选项
        //获取默认相册
        'GetDefaultAlbumError'=>[ 'code'=>10000, 'msg'=>'获取默认相册失败','error'=>'GetDefaultAlbumError' ],
        //查找相册
        'FindAlbumError'=>[ 'code'=>10000, 'msg'=>'查找相册失败','error'=>'FindAlbumError' ],

     //|--|--|--|--图片处理


        //设置封面
        'SetCoverError'=>[ 'code'=>10000, 'msg'=>'设置封面失败','error'=>'SetCoverError' ],
        'SetCoverEventError'=>[ 'code'=>10000, 'msg'=>'设置封面事件失败','error'=>'SetCoverEventError' ],
        //移动相册
        'MoveAlbumError'=>[ 'code'=>10000, 'msg'=>'移动相册失败','error'=>'MoveAlbumError' ],
        'MoveAlbumEventError'=>[ 'code'=>10000, 'msg'=>'移动相册失败','error'=>'MoveAlbumEventError' ],
        //批量移动相册
        'MoveMultipleAlbumError'=>[ 'code'=>10000, 'msg'=>'批量移动相册失败','error'=>'MoveMultipleAlbumError' ],
        'MoveMultipleAlbumEventError'=>[ 'code'=>10000, 'msg'=>'批量移动相册失败','error'=>'MoveMultipleAlbumEventError' ],
        //删除图片
        'DeletePictureError'=>[ 'code'=>10000, 'msg'=>'删除图片失败','error'=>'DeletePictureError' ],
        'DeletePictureEventError'=>[ 'code'=>10000, 'msg'=>'删除图片事件失败','error'=>'DeletePictureEventError' ],
        //批量删除图片
        'DeleteMultiplePictureError'=>[ 'code'=>10000, 'msg'=>'批量删除图片失败','error'=>'DeleteMultiplePictureError' ],
        'DeleteMultiplePictureEventError'=>[ 'code'=>10000, 'msg'=>'批量删除图片事件失败','error'=>'DeleteMultiplePictureEventError' ],
        //更新图片名称
        'UpdatePictureNameError'=>[ 'code'=>10000, 'msg'=>'更新图片失名称败','error'=>'UpdatePictureNameError' ],
        'UpdatePictureNameEventError'=>[ 'code'=>10000, 'msg'=>'更新图片名称事件失败','error'=>'UpdatePictureNameEventError' ],
];
