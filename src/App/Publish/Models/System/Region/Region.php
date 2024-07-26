<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2023-02-21 14:59:26
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-04-06 20:59:36
 */

namespace App\Models\System\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\User\UserAddress;

class Region extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'region';
    protected $guarded = [''];


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
     * 定义 地区国家对 用户地址 一对多
     *
     * @return void
     */
    public function country()
    {
        return $this->hasMany(UserAddress::class,'country_id','id');
    }

     /**
     * 定义 地区省份对 用户地址 一对多
     *
     * @return void
     */
    public function province()
    {
        return $this->hasMany(UserAddress::class,'province_id','id');
    }

     /**
     * 定义 地区区域对 用户地址 一对多
     *
     * @return void
     */
    public function region()
    {
        return $this->hasMany(UserAddress::class,'region_id','id');
    }

    /**
     *定义 地区城市对 用户地址 一对多
     * @return void
     */
    public function city()
    {
        return $this->hasMany(UserAddress::class,'city_id','id');
    }

    /**
     * 定义 地区城镇对 用户地址 一对多
     *
     * @return void
     */
    public function towns()
    {
        return $this->hasMany(UserAddress::class,'towns_id','id');
    }

     /**
     * 定义 地区乡村街道 用户地址 一对多
     *
     * @return void
     */
    public function village()
    {
        return $this->hasMany(UserAddress::class,'village_id','id');
    }

}
