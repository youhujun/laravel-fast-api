<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-17 11:35:00
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-12-01 17:59:11
 */

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\User\User;

class UserWechat extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'user_wechat';
    protected $guarded = [''];
    protected $attributes =
    [

    ];


    //================================================分割线===========================================================

    /**
     * 对应  用户微信对用户  多对一 注意找到默认的
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
