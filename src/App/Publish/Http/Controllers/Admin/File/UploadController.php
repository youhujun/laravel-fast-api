<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-20 23:05:04
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 12:19:33
 * @FilePath: \app\Http\Controllers\Admin\File\UploadController.php
 */

namespace App\Http\Controllers\Admin\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use App\Rules\Public\Required;
use App\Rules\Public\Numeric;
use App\Rules\Public\CheckString;
use App\Rules\Public\CheckBetween;
use App\Rules\Public\CheckArray;
use App\Rules\Public\FormatTime;
use App\Rules\Public\CheckUnique;
use App\Rules\Public\ChineseCodeNumberLine;

use App\Rules\Public\FileType;
use App\Rules\Admin\File\Action;
use App\Rules\Admin\File\UseType;


use App\Facade\Admin\File\AdminUploadFacade;

class UploadController extends Controller
{
	 /**
    * Undocumented function  上传配置文件
    *
    * @param Request $request
    * @return void
    */
    public function uploadConfigFile(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
               [
                     //文件操作类型 可以为空 例如 bank,shopType就是执行excel表格数据导入
                    'type'=>['bail','nullable',new Action],
                    //使用类型 10系统配置 20管理员 30后台
                    'use_type'=>['bail',new Required,new Numeric,new UseType],
                    //文件格式类型 暂时注释不接收
                    'file_type'=>['bail','nullable'],
                    //文件保存路径
                    'save_path'=>['bail','nullable',new ChineseCodeNumberLine],
               ],
               []
           );
           $validated = $validator->validated();

            if($request->hasFile('file'))
            {
                $file = $request->file('file');
                $result = AdminUploadFacade::uploadConfigFile($validated , $admin , $file);
            }
        }
        return $result;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function uploadFile(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                   //文件操作类型 可以为空 例如 bank,shopType就是执行excel表格数据导入
                    'type'=>['bail','nullable',new Action],
                    //使用类型 10系统配置 20管理员 30后台
                    'use_type'=>['bail',new Required,new Numeric,new UseType],
                    //文件格式类型 暂时注释不接收
                    'file_type'=>['bail','nullable',new FileType],
                    //文件保存路径
                    'save_path'=>['bail','nullable',new ChineseCodeNumberLine],
               ],
               []
           );

           $validated = $validator->validated();

           //p($validated);die;

            if($validated)
            {
                if($request->hasFile('file'))
                {
                    $file = $request->file('file');

                    $result = AdminUploadFacade::uploadFile( $validated ,$admin, $file);
                }
            }
        }

        return $result;
    }

    /**
     * 上传单图
     *
     * @param Request $request
     * @return void
     */
    public function uploadSinglePicture(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                    'id'=>['bail','nullable',new Numeric],
                    //使用类型 10系统配置 20管理员 30后台
                    'use_type'=>['bail',new Required,new Numeric,new UseType],
                    //文件格式类型 暂时注释不接收
                    'file_type'=>['bail','nullable',new FileType],
                    //文件保存路径
                    'save_path'=>['bail','nullable',new ChineseCodeNumberLine],
               ],
               []
            );

            $validated = $validator->validated();

            if($validated)
            {
                if( $request->hasFile('picture'))
                {
                    $picture = $request->file('picture');

                    $result = AdminUploadFacade::uploadSinglePicture( $validated ,$admin, $picture);
                }
            }
        }

        return $result;
    }

    /**
     * 上传多图
     *
     * @param Request $request
     * @return void
     */
    public function uploadMultiplePicture(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
               [
                    'id'=>['bail','nullable',new Numeric],
                    //使用类型 10系统配置 20管理员 30后台
                    'use_type'=>['bail',new Required,new Numeric,new UseType],
                    //文件格式类型 暂时注释不接收
                    'file_type'=>['bail','nullable',new FileType],
                    //文件保存路径
                    'save_path'=>['bail','nullable',new ChineseCodeNumberLine],
               ],
               []
            );

            $validated = $validator->validated();

            //p($validated);die;

            if($request->hasFile('picture'))
            {
                $pictures = $request->file('picture');

                $result = AdminUploadFacade::uploadMultiplePicture( $validated ,$admin, $pictures);
            }

        }

        return $result;
    }

    /**
     * 上传用户头像
     *
     * @param Request $request
     * @return void
     */
    public function uploadUserAvatar(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                    'id'=>['bail','nullable',new Numeric],
                    //用户id
                    'user_id'=>['bail',new Required,new Numeric],
                    //图片id 替换上传是传入 可以为0
                    'picture_id'=>['bail','nullable',new Numeric],
                    //使用类型 10系统配置 20管理员 30后台
                    'use_type'=>['bail',new Required,new Numeric,new UseType],
                    //文件格式类型 暂时注释不接收
                    'file_type'=>['bail','nullable',new FileType],
                    //文件保存路径
                    'save_path'=>['bail','nullable',new ChineseCodeNumberLine],
               ],
               []
            );

            $validated = $validator->validated();

            if($validated)
            {
                if( $request->hasFile('picture'))
                {
                    $picture = $request->file('picture');

                    $result = AdminUploadFacade::uploadUserAvatar( $validated ,$admin, $picture);
                }
            }
        }

        return $result;
    }


     /**
     * 上传替换图片
     *
     * @param Request $request
     * @return void
     */
    public function uploadResetPicture(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.AdminAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {

            $validator = Validator::make(
                $request->all(),
               [
                    'id'=>['bail','nullable',new Numeric],
                    //图片id 替换上传是传入 可以为0
                    'picture_id'=>['bail','nullable',new Numeric],
                    //使用类型 10系统配置 20管理员 30后台
                    'use_type'=>['bail',new Required,new Numeric,new UseType],
                    //文件格式类型 暂时注释不接收
                    'file_type'=>['bail','nullable',new FileType],
                    //文件保存路径
                    'save_path'=>['bail','nullable',new ChineseCodeNumberLine],
               ],
               []
            );

            $validated = $validator->validated();

            if($validated)
            {
                if( $request->hasFile('picture'))
                {
                    $picture = $request->file('picture');

                    $result = AdminUploadFacade::uploadResetPicture( $validated ,$admin, $picture);
                }
            }
        }

        return $result;
    }
}
