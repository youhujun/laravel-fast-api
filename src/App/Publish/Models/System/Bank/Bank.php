<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-21 15:42:20
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-04-06 20:48:00
 */

namespace App\Models\System\Bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use  App\Models\User\UserBank;

class Bank extends Model
{
   use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'bank';
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
     * 定义 一对多  银行对用户银行卡
     *
     * @return void
     */
    public function userBank()
    {
        return $this->hasMany(UserBank::class,'bank_id','id');
    }
}
