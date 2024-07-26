<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-05-26 11:08:56
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 12:16:22
 * @FilePath: \app\Models\Goods\GoodsClass.php
 */

namespace App\Models\Goods;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use App\Models\Picture\AlbumPicture;

class GoodsClass extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

	//链接
	protected $connection = 'mysql';
	//表名
    protected $table = 'goods_class';
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

    protected function deletedAt():Attribute
    {
        return new Attribute(

            set:fn($time) => date('Y-m-d H:i:s',$time),
        );
    }

    protected function rate():Attribute
    {
        return new Attribute(
            set:fn($rate) => \bcdiv($rate,100,2),
        );
    }

    /**
     * 想对 多对一 相册图片表
     *
     * @return void
     */
    public function picture()
    {
        return $this->belongsTo(AlbumPicture::class,'goods_class_picture_id', 'id');
    }

}
