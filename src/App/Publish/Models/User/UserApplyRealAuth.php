<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-04-03 09:16:05
 * @LastEditors: YouHuJun
 * @LastEditTime: 2023-04-03 10:00:50
 */

namespace App\Models\User;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use App\Models\User\User;

class UserApplyRealAuth extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

    public $timestamps = false;
    protected $table = 'user_apply_real_auth';
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



    protected function authApplyAt():Attribute
    {
          return new Attribute(

            set:fn($time) => date('Y-m-d H:i:s',$time),
        );
    }

    protected function authAt():Attribute
    {
          return new Attribute(

            set:fn($time) => date('Y-m-d H:i:s',$time),
        );
    }


    /**
     * 定义 相对 多对一 用户实名热认证申请对用户
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }



}
