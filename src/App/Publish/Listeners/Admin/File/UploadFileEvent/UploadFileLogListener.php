<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-21 00:01:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-23 01:09:55
 * @FilePath: \app\Listeners\Admin\File\UploadFileEvent\UploadFileLogListener.php
 */

namespace App\Listeners\Admin\File\UploadFileEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

use App\Exceptions\Admin\CommonException;

use App\Models\Admin\Log\AdminUploadFileLog;

class UploadFileLogListener
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
        $uploadFileLogData = $event->uploadFileLogData;

        $logDataType = $event->logDataType;

        //保存日志

        //单文件
        if($logDataType == 10)
        {
            $uploadFileLog = new AdminUploadFileLog;

            foreach ($uploadFileLogData as $key => $value)
            {
                $uploadFileLog->$key = $value;
            }

            $uploadFileLog->created_at = time();
            $uploadFileLog->created_time = time();

            $uploadFileLogResult = $uploadFileLog->save();

        }

        //多文件
        if($logDataType == 20)
        {

            foreach ($uploadFileLogData as $key => &$item)
            {
               $item['created_at'] = date('Y-m-d H:i:s',time());
               $item['created_time'] = time();
            }

            $uploadFileLogResult = AdminUploadFileLog::insert($uploadFileLogData);

        }

        if(!$uploadFileLogResult)
        {
            throw new CommonException('UploadFileLogError');
        }

    }
}
