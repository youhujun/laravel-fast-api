<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-27 21:59:28
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 15:37:35
 */

namespace App\Models\Admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Redis;

use App\Models\User\User;
use App\Models\Picture\Album;
use App\Models\Article\Article;

use App\Models\Admin\Log\AdminLoginLog;
use App\Models\Admin\Log\AdminEventLog;

class Admin extends Authenticatable
{
    use HasFactory,Notifiable,SoftDeletes;

   //链接
	protected $connection = 'mysql';
	//表名
    protected $table = 'admin';
	//主键
	protected $primaryKey = 'id';
	//是否自动维护时间戳
	public $timestamps = false;
	//时间戳格式
	protected $dateFormat = 'Y-m-d H:i:s';
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
     * 是否是开发者
     *
     * @return boolean
     */
    public function isDevelop()
    {
        $rolesArray = $this->getAdminRoles();

        $result = 0;

        $result = \in_array('develop',$rolesArray);

        return $result;
    }

    /**
     * 是否是超级管理员
     *
     * @return boolean
     */
    public function isSuper()
    {
        $rolesArray = $this->getAdminRoles();

        $result = 0;
        $developResult = \in_array('develop',$rolesArray);
        $superResult = \in_array('super',$rolesArray);

        if($developResult || $superResult )
        {
            $result = 1;
        }

        return $result;
    }

    /**
     * 是否是管理员
     *
     * @return boolean
     */
    public function isAdmin()
    {
        $rolesArray = $this->getAdminRoles();

        $result = 0;

        $developResult = \in_array('develop',$rolesArray);
        $superResult = \in_array('super',$rolesArray);
        $adminResult = \in_array('admin',$rolesArray);

        if($developResult || $superResult || $adminResult)
        {
            $result = 1;
        }

        return $result;
    }

    /**
     * 是否是用户
     *
     * @return boolean
     */
    public function isUser()
    {
         $rolesArray = $this->getAdminRoles();

        $result = 0;

        $developResult = \in_array('develop',$rolesArray);
        $superResult = \in_array('super',$rolesArray);
        $adminResult = \in_array('admin',$rolesArray);
        $userResult = \in_array('user',$rolesArray);

        if($developResult || $superResult || $adminResult || $userResult)
        {
            $result = 1;
        }

        return $result;
    }

    /**
	 * 获取管理员角色
	 *
	 * @param  \App\Models\Admin\Admin $admin
	 */
	public function getAdminRoles()
	{
		 $redisRoles = Redis::hget("admin_roles:admin_roles",$this->id);

		 $rolsArray = [];

		 if($redisRoles)
		 {
			$rolsArray = json_decode($redisRoles,true);
		 }
		 else
		 {
			$rolesArray = $this->user->getRoles();

			$result = 0;

			if(count($rolesArray))
			{
				$result =  Redis::hset("admin_roles:admin_roles",$this->id,json_encode($rolesArray));
			}

			if(!$result)
			{
				Log::debug(['RedisSaveAdminRolesError'=>'缓存管理员角色失败']);
			}
		 }

		 return $rolsArray;

	}

    //模型关系
    public function album()
    {
        return $this->hasMany(Album::class,'admin_id','id');
    }

    //文章
    public function article()
    {
        return $this->hasMany(Article::class,'admin_id','id');
    }

    //管理员登录日志
    public function loginLog()
    {
        return $this->hasMany(AdminLoginLog::class,'admin_id','id');
    }

     //管理员事件日志
    public function eventLog()
    {
        return $this->hasMany(AdminEventLog::class,'admin_id','id');
    }


    //=====相对分割线=====

    /**
     * 对应  管理员 对用户 一对一
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }









}
