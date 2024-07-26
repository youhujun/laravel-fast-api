<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-20 23:57:53
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-23 00:59:48
 * @FilePath: \app\Events\Admin\File\UploadFileEvent.php
 */

namespace App\Events\Admin\File;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\Admin;

/**
 * @see \App\Listeners\Admin\File\UploadFileEvent\UploadFileLogListener
 * @see \App\Listeners\Admin\File\UploadFileEvent\UploadFileImportListener
 */
class UploadFileEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   //管理员
    public $admin;

    //上传文件日志数据
    public $uploadFileLogData;

    //上传文件日志数据类型 10 单文件 20多文件
    public $logDataType = 10;

    //$path 文件位置
    public $path;

    //文件类型
    public $fileType;

    //根据动作类型来操作 例如上传excel表格 bank 导入数据
    public $actionType;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,$uploadFileLogData,$path,$fileType,$actionType,$logDataType = 10)
    {
        $this->admin = $admin;
        $this->uploadFileLogData = $uploadFileLogData;
        $this->path = $path;
        //根据文件类型 和 $actionType来采取动作
        $this->fileType = $fileType;
        $this->actionType = $actionType;
        $this->logDataType = $logDataType;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
