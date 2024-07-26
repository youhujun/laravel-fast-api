<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-03-16 09:38:02
 * @LastEditors: YouHuJun
 * @LastEditTime: 2023-03-17 10:20:16
 */

namespace App\Models\User;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use App\Models\User\User;
use App\Models\Picture\AlbumPicture;

class UserIdCard extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

    public $timestamps = false;
    protected $table = 'user_id_card';
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
     * 对应  用户身份证和用户  一对一
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


    /**
     * 对应  身份证正面和 用户相册图片 一对一
     *
     * @return void
     */
    public function cardFront()
    {
        return $this->belongsTo(AlbumPicture::class,'id_card_front_id','id');
    }

    /**
     * 对应  身份证背面和 用户相册图片 一对一
     *
     * @return void
     */
    public function cardBack()
    {
        return $this->belongsTo(AlbumPicture::class,'id_card_back_id','id');
    }

}
