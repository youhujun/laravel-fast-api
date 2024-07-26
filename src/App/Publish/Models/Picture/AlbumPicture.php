<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-24 22:23:43
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 21:17:39
 */

namespace App\Models\Picture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\User\UserAvatar;
use App\Models\User\UserQrcode;
use App\Models\User\UserBank;
use App\Models\User\User;

use App\Models\Article\Category;
use App\Models\Goods\GoodsClass;
use App\Models\Help\Label;


use App\Models\System\PhoneBannner;

class AlbumPicture extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'album_picture';
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
     * 定义 图片和手机轮播图 一对一
     *
     * @return void
     */
    public function phoneBanner()
    {
        return $this->hasOne(PhoneBanner::class,'album_picture_id','id');
    }


    /**
     * 定义 用户相册图片相对用户头像 一对一
     *
     * @return void
     */
    public function userAvatar()
    {
        return $this->hasMany(UserAvatar::class,'album_picture_id','id');
    }

    /**
     * 定义 用户相册图片相对用户二维码 一对一
     *
     * @return void
     */
    public function userQrcode()
    {
        return $this->hasMany(UserQrcode::class,'album_picture_id','id');
    }

    /**
     * 定义 用户相册图片相对相册封面 一对一
     *
     * @return void
     */
    public function coverAlbum()
    {
        return $this->hasMany(Album::class,'cover_album_picture_id','id');
    }


/**
     * 定义 一对一 银行卡正面
     *
     * @return void
     */
    public function bankFront()
    {
        return $this->hasOne(UserBank::class,'bank_front_id','id');
    }

    /**
     * 定义 一对一 银行卡背面
     *
     * @return void
     */
    public function bankBack()
    {
        return $this->hasOne(UserBank::class,'bank_back_id','id');
    }




    /**
     * 定义 一对多 文章分类
     *
     * @return void
     */
    public function category()
    {
        return  $this->hasMany(Category::class,'category_picture_id','id');
    }

    /**
     * 定义 一对多 产品分类
     */
    public function goodsClass()
    {
         return $this->hasMany(GoodsClass::class,'goods_class_picture_id','id');
    }

    /**
     * 定义 一对多 标签
     */
    public function label()
    {
         return $this->hasMany(GoodsClass::class,'label_picture_id','id');
    }

    //================================================分割线===========================================================

    /**
     * 对应 用户相册图片对用户 多对一
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

     /**
     * 对应 用户相册图片对 用户相册 多对一
     *
     * @return void
     */
    public function album()
    {
        return $this->hasMany(Album::class,'album_id','id');
    }









}
