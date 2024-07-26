<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-22 14:34:42
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-12-01 17:58:21
 */

namespace App\Models\System\Permission;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\System\Role\Role;

class Permission extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'permission';
    protected $guarded = [''];
    protected $attributes =
    [

    ];

    /**
     * 强制转换的属性
     *
     * @var array
     */
    protected $casts = [
        'alwaysShow' => 'boolean',
        'meta_noCache' => 'boolean',
        'hidden' => 'boolean',
        'meta_affix' => 'boolean',
        'meta_breadcrumb' => 'boolean'

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
     *  对应 权限相对角色  多对多
     *
     * @return void
     */
    public function role()
    {
        return $this->belongsToMany(Role::class,'role_permission_union','permission_id','role_id');
    }

}

