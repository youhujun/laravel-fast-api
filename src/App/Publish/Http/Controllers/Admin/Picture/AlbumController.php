<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-01 22:38:55
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 12:40:54
 * @FilePath: \app\Http\Controllers\Admin\Picture\AlbumController.php
 */


namespace App\Http\Controllers\Admin\Picture;

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

use App\Rules\Admin\Common\sortType;

use App\Facade\Admin\Picture\AdminAlbumFacade;

class AlbumController extends Controller
{
    /**
     * 获取默认相册
     *
     * @param Request $request
     * @return void
     */
    public function getDefaultAlbum(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'album_type'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();
            //p($validated);die;
            $result =  AdminAlbumFacade::getDefaultAlbum(f($validated),$admin);
        }

        return $result;
    }


    /**
     * 查找相册
     *
     * @param Request $request
     * @return void
     */
    public function findAlbum(Request $request)
    {
        $result = code(\config('admin_code.AdminAuthError'));

        $admin = Auth::guard('admin_token')->user();

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'find' => ['bail','nullable',new CheckString],
                    'album_type'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            $result =  AdminAlbumFacade::findAlbum(f($validated),$admin);
        }

        return $result;
    }
    /**
     * 获取相册
     *
     * @param AlbumRequest $request
     * @return void
     */
    public function getAlbum(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        if (Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
               [
                   'album_type'=>['bail','nullable',new Numeric],
                   'sortType'=>['bail','nullable',new Numeric,new sortType],
                   'currentPage'=>['bail','nullable',new Numeric],
                   'pageSize'=>['bail','nullable',new Numeric],

               ],
               []
           );

           $validated = $validator->validated();
           //p($validated);die;
           $result = AdminAlbumFacade::getAlbum(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 添加相册
     *
     * @param Request $request
     * @return void
     */
    public function addAlbum(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.apiAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'album_type'=>['bail',new Required,new Numeric],
                    'album_name' => ['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine],
                    'album_description' => ['bail','nullable',new CheckBetween(0,50)],
                    'sort'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            $result = AdminAlbumFacade::addAlbum(f($validated),$admin);
        }

        return $result;
    }

    /**
     * 更新相册
     *
     * @param Request $request
     * @return void
     */
    public function updateAlbum(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.apiAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric],
                    'album_type'=>['bail',new Required,new Numeric],
                    'album_name' => ['bail',new Required,new CheckString,new CheckBetween(1,30),new ChineseCodeNumberLine],
                    'album_description' => ['bail','nullable',new CheckBetween(0,50)],
                    'sort'=>['bail',new Required,new Numeric],
                ],
                []
            );

            $validated = $validator->validated();

            /**
             * @see \App\Policies\Admin\Picture\AlbumPolicy
             */
            if(Gate::forUser($admin)->allows('update-album',[$validated]))
            {
                $result = AdminAlbumFacade::updateAlbum($validated,$admin);
            }
        }
        return $result;
    }

    /**
     * 删除相册
     *
     * @param Request $request
     * @return void
     */
    public function deleteAlbum(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(\config('admin_code.apiAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=>['bail',new Required,new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            /**
             * @see \App\Policies\Admin\PictureAlbumPolicy
             */
            if(Gate::forUser($admin)->allows('delete-album',[$validated]))
            {
                $result = AdminAlbumFacade::deleteAlbum($validated,$admin);
            }
        }
        return $result;
    }

    /**
     * 查询相册
     *
     * @param Request $request
     * @return void
     */
    public function getAlbumPicture(Request $request)
    {
        $admin = Auth::guard('admin_token')->user();

        $result = code(config('admin_code.apiAuthError'));

        if(Gate::forUser($admin)->allows('admin-role'))
        {
            $validator = Validator::make(
                $request->all(),
                [
                    'id'=> ['bail',new Required,new Numeric],
                    'sortType'=>['bail',new Required,new Numeric],
                    'currentPage'=>['bail','nullable',new Numeric],
                    'pageSize'=>['bail','nullable',new Numeric]
                ],
                []
            );

            $validated = $validator->validated();

            //p($validated);die;

            /**
             * @see \App\Policies\Admin\Picture\AlbumPolicy
             */
            if(Gate::forUser($admin)->allows('get-album-picture',[$validated]))
            {
                $result = AdminAlbumFacade::getAlbumPicture($validated,$admin);
            }

        }

        return $result;
    }
}
