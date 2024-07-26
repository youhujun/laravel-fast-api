<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-17 11:33:57
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-25 15:29:44
 */

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\User\User;
use App\Models\System\Region\Region;

class UserAddress extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'user_address';
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


    //================================================相对分割线===========================================================

     /**
     * 对应  用户地址对用户  多对一 主要找到默认的,类型是家庭和公司的
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * 对应 地址国家 对 地区  多对一
     *
     * @return void
     */
    public function country()
    {
        return $this->belongsTo(Region::class,'country_id','id');
    }

     /**
     * 对应 地址省份 对 地区  多对一
     *
     * @return void
     */
    public function province()
    {
        return $this->belongsTo(Region::class,'province_id','id');
    }

     /**
     * 对应 地址区域 对 地区  多对一
     *
     * @return void
     */
    public function region()
    {
        return $this->belongsTo(Region::class,'region_id','id');
    }

    /**
     * 对应 地址城市 对 地区  多对一
     *
     * @return void
     */
    public function city()
    {
        return $this->belongsTo(Region::class,'city_id','id');
    }

    /**
     * 对应 地址城镇 对 地区  多对一
     *
     * @return void
     */
    public function towns()
    {
        return $this->belongsTo(Region::class,'towns_id','id');
    }

     /**
     * 对应 地址乡村街道 对 地区  多对一
     *
     * @return void
     */
    public function village()
    {
        return $this->belongsTo(Region::class,'village_id','id');
    }

}
