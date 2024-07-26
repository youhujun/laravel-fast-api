<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-07-24 14:49:06
 * @LastEditors: YouHuJun
 * @LastEditTime: 2023-07-31 08:49:41
 */
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-17 11:37:44
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-12-01 17:59:46
 */

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\User\User;
use App\Models\Picture\AlbumPicture;

class UserAvatar extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'user_avatar';
    protected $guarded = [''];
    protected $attributes =
    [

    ];

    protected function createdAt():Attribute
    {
        return new Attribute(

            set:fn($time) => date('Y-m-d H:i:s',$time),
        );
    }

    protected function updatedAt():Attribute
    {
        return new Attribute(

            set:fn($time) => date('Y-m-d H:i:s',$time),
        );
    }



     //================================================分割线===========================================================

     /**
     * 对应 用头像对用户 多对一
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * 对应  用户头像和 用户相册图片 一对一
     *
     * @return void
     */
    public function albumPicture()
    {
        return $this->belongsTo(AlbumPicture::class,'album_picture_id','id');
    }
}
