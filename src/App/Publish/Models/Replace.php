<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-07 16:09:22
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 20:42:02
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Replace extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

	//链接
	protected $connection = '';
	//表名
    protected $table = '';
	//主键
	protected $primaryKey = 'id';
	//是否自动维护时间戳
	public $timestamps = false;
	//时间戳格式
	protected $dateFormat = 'Y-m-d H:i:s';

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


    protected function arribute():Attribute
    {
        return new Attribute(

            set:fn($value) => $value,
            get:fn($value) => $value,
        );
    }

}
