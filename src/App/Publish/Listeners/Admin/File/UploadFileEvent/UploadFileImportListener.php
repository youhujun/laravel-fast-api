<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-21 00:04:33
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 11:51:43
 * @FilePath: \app\Listeners\Admin\File\UploadFileEvent\UploadFileImportListener.php
 */

namespace App\Listeners\Admin\File\UploadFileEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;

use App\Exceptions\Admin\CommonException;

use App\Facade\Admin\System\Bank\AdminBankFacade;

/**
 * @see \App\Events\Admin\File\UploadFileEvent
 */
class UploadFileImportListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {

        $admin = $event->admin;
        // 根据文件类型 和 action 来采取动作
        $fileType = $event->fileType;

        //根据动作类型来决定做什么操作
        $actionType = $event->actionType;

        //文件路径
        $path = $event->path;

        //同时设置了文件类型 和操作类型才执行
        //文件类型是文件后缀名 操作类型 是例如 bank 等 指明关坚词
        if(isset($fileType) && isset($actionType))
        {
             //当文件类型为excel表格执行操作

            if($fileType == 'xlsx' || $fileType == 'xls')
            {
                if($actionType == 'bank')
                {
                    AdminBankFacade::importData($path);
                }

            }
        }
    }
}
