<?php
/*
 * @Descripttion: 
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-29 14:13:38
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-29 14:40:48
 * @FilePath: \app\Models\User\Log\UserLocationLog.php
 */

namespace App\Models\User\Log;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use App\Models\User\User;

class UserLocationLog extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

	//链接
	protected $connection = 'mysql';
	//表名
    protected $table = 'user_location_log';
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

	//定义 多对一 用户位置日志相对用户
	public function user()
	{
		return $this->belongsTo(User::class,'user_id','id');
	}

}
