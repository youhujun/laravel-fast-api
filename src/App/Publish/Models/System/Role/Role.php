<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-08-22 14:34:42
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-24 23:04:00
 */

namespace App\Models\System\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Admin\Admin;
use App\Models\User\User;
use App\Models\System\Permission\Permission;

class Role extends Model
{
    use HasFactory,SoftDeletes;
    public $timestamps = false;
    protected $table = 'role';
    protected $guarded = [''];
    protected $attributes =
    [

    ];
    //默认预加载
  /*   protected $with = ['permission']; */

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
     * 定义 角色和权限  多对多
     *
     * @return void
     */
    public function permission()
    {
        return $this->belongsToMany(Permission::class,'role_permission_union','role_id','permission_id')->wherePivot('deleted_at',null);
    }

    /**
     * 对应 角色和用户 多对多
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsToMany(User::class,'user_role_union','role_id','user_id');
    }

    /**
     * 定义角色和管理员相对的多对多关联
     *
     * @return void
     */
    public function admin()
    {
        return $this->belongsToMany(Admin::class,'admin_role_union','role_id','admin_id');
    }
}
