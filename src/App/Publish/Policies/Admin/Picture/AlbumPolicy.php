<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-02 12:28:45
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-02 12:35:11
 * @FilePath: \app\Policies\Admin\Picture\AlbumPolicy.php
 */

namespace App\Policies\Admin\Picture;


use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlbumPolicy
{
    //use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * 更新相册
     *
     * @param Admin $admin
     * @param Album $album
     * @return void
     */
    public function update(Admin $admin,$valdiated)
    {
       $result = $this->common($admin,$valdiated);

        return $result;
    }

    /**
     * 删除相册
     *
     * @param Admin $admin
     * @param [type] $id
     * @return void
     */
    public function delete(Admin $admin,$valdiated)
    {

        $result = $this->common($admin,$valdiated);

        return $result;
    }

    /**
     * 查看相册图片
     *
     * @param Admin $admin
     * @param [type] $valdiated
     * @return void
     */
    public function getAlbumPicture(Admin $admin,$valdiated)
    {
        $result = $this->common($admin,$valdiated);

        return $result;
    }


    /**
     * 授权共同处理逻辑
     *
     * @param Admin $admin
     * @param [type] $valdiated
     * @return void
     */
    protected function common(Admin $admin,$valdiated)
    {
        $result = true;

        $album_id = $valdiated['id'];

        $album = Album::find($album_id);

        if($admin->id !== $album->admin_id)
        {
            $result = false;
        }

        return $result;
    }


}
