<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2023-08-22 13:35:59
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2023-08-28 09:36:46
 * @FilePath: \api.laravel.com_LV9\app\Models\System\PhoneBannner.php
 */

namespace App\Models\System;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use App\Models\User\User;
use App\Models\Picture\AlbumPicture;

class PhoneBannner extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

    public $timestamps = false;
    protected $table = 'phone_banner';
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

    /**
     * 定义相对  多对一 手机轮播图 对用户 ())
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * 定义相对 一对一 手机轮播图 对相册图片
     *
     * @return void
     */
    public function picture()
    {
       return $this->belongsTo(AlbumPicture::class,'album_picture_id','id');
    }

}
