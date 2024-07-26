<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-28 08:06:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-01 11:43:19
 * @FilePath: \app\Http\Controllers\Admin\File\DownloadController.php
 */

namespace App\Http\Controllers\Admin\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class DownloadController extends Controller
{
     protected static $basePath;

    protected $path;

    protected $downloadPath;

        /**
     * Class constructor.
     */
    public function __construct()
    {
       self::$basePath = 'excel'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR;
    }

    /**
     * 设置路径
     *
     * @param string $name
     * @return void
     */
    protected function setPath(string $name)
    {
        $this->path = self::$basePath."{$name}".DIRECTORY_SEPARATOR.'template.xlsx';

        $this->downloadPath = 'storage'.DIRECTORY_SEPARATOR. $this->path;
    }

    /**
     * 下载银行模板
     *
     * @return void
     */
    public function downloadBank()
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        $download = '';

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $result = code(config('admin_code.DownLoadError'));

            $this->setPath('bank');

            $exists = Storage::disk('public')->exists($this->path);

            if($exists)
            {
                $download = asset($this->downloadPath);

                $result = code(['code'=>0,'msg'=>'下载成功!'],['download' => $download]);
            }
        }

        return $result;
    }
}
