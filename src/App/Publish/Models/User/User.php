<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-05-23 15:35:15
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-28 08:03:45
 */

namespace App\Models\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

//系统
//角色
use App\Models\System\Role\Role;

use App\Models\Admin\Admin;

use App\Models\Picture\Album;
use App\Models\Picture\AlbumPicture;

use App\Models\Article\Article;

use App\Models\User\Log\UserBalanceLog;
use App\Models\User\Log\UserCoinLog;
use App\Models\User\Log\UserScoreLog;
use App\Models\User\Log\UserEventLog;
use App\Models\User\Log\UserLoginLog;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   /*  protected $fillable = [
        'name',
        'email',
        'password',
    ]; */

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /* protected $hidden = [
        'password',
        'remember_token',
    ]; */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
   /*  protected $casts = [
        'email_verified_at' => 'datetime',
    ]; */

    //链接
	protected $connection = 'mysql';
	//表名
    protected $table = 'users';
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



    protected function balance():Attribute
    {
        return new Attribute(

            get:fn($value) => \number_format($value,2),
        );
    }

    protected function coin():Attribute
    {
        return new Attribute(

            get:fn($value) => \number_format($value,2),
        );
    }

    protected function score():Attribute
    {
        return new Attribute(

            get:fn($value) => \number_format($value,2),
        );
    }

    /**
     * 获取用户角色
     */
    public function getRoles()
    {
        $role = $this->role;

        $roleArray = [];

        foreach($role as $key => $roleItem)
        {
            $roleArray[] = $roleItem->logic_name;
        }

        return $roleArray;
    }

     /**
     * 是否是开发者
     *
     * @return boolean
     */
    public function isDevelop()
    {
        $rolesArray = $this->getRoles();

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
        $rolesArray = $this->getRoles();

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
        $rolesArray = $this->getRoles();

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
        $rolesArray = $this->getRoles();

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
    * 定义 用户和管理员 一对一
    *
    * @return void
    */
   public function admin()
   {
       return $this->hasOne(Admin::class,'user_id','id');
   }

    /**
    * 定义 用户和身份证
    *
    * @return void
    */
   public function idCard()
   {
       return $this->hasOne(UserIdCard::class,'user_id','id');
   }

   /**
    * 定义 用户和用户信息 一对一
    *
    * @return void
    */
   public function userInfo()
   {
       return $this->hasOne(UserInfo::class,'user_id','id');
   }

   /**
    * 定义 用户和用户头像 一对多 注意要找默认的头像一个
    *
    * @return void
    */
   public function userAvatar()
   {
       return $this->hasMany(UserAvatar::class,'user_id','id');
   }

   /**
    * 定义 用户和用户二维码  一对多 注意要找默认的头像一个
    *
    * @return void
    */
   public function userQrcode()
   {
       return $this->hasMany(UserQrcode::class,'user_id','id');
   }



   /**
    * 定义 用户对用户地址 一对多 , 主要找到默认的,并且类型是 公司,家庭等
    *
    * @return void
    */
   public function userAddress()
   {
        return $this->hasMany(UserAddress::class,'user_id','id');
   }

    /**
    * 定义 用户对用户微信 一对多  ,多数是一个,不排除会有不同微信,注意需要找到默认使用的微信
    *
    * @return void
    */
    public function userWechat()
    {
         return $this->hasMany(UserWechat::class,'user_id','id');
    }

   /**
    * 定义 用户和用户事件日志 一对多
    *
    * @return void
    */
    public function userEventLog()
    {
        return $this->hasMany(UserEventLog::class,'user_id','id');
    }

    /**
     * 定义 用户和用户登录日志 一对多
     *
     * @return void
     */
    public function userLoginLog()
    {
        return $this->hasMany(UserLoginLog::class,'user_id','id');
    }

    /**
     * 定义 用户和角色 多对多
     *
     * @return void
     */
    public function role()
    {
        //return $this->belongsToMany(Role::class,'user_role_union','user_id','role_id')->wherePivot('deleted_at', null);
        return $this->belongsToMany(Role::class,'user_role_union','user_id','role_id');
    }

    /**
     * 定义 用户和用户相册 一对多
     *
     * @return void
     */
    public function album()
    {
        return $this->hasMany(Album::class,'user_id','id');
    }

     /**
     * 定义 用户和用户相册让图片 一对多
     *
     * @return void
     */
    public function picture()
    {
        return $this->hasMany(AlbumPicture::class,'user_id','id');
    }

       /**
    * 定义 用户和文章 一对多
    *
    * @return void
    */
   public function article()
   {
       return $this->hasMany(Article::class,'publisher_id','id');
   }

   /**
    * 定义 用户和银行卡 一对多
    *
    * @return void
    */
   public function userBank()
   {
        return $this->hasMany(UserBank::class,'user_id','id');

   }


   /**
    * 定义 一对对多 用户对用户余额日志
    *
    * @return void
    */
   public function balanceLog()
   {
       return $this->hasMany(UserBalanceLog::class,'user_id','id');
   }

   /**
    * 定义 一对对多 用户对用户余额日志
    *
    * @return void
    */
   public function coinLog()
   {
       return $this->hasMany(UserCoinLog::class,'user_id','id');
   }

   /**
    * 定义 一对对多 用户对用户余额日志
    *
    * @return void
    */
   public function scoreLog()
   {
       return $this->hasMany(UserScoreLog::class,'user_id','id');
   }




    //================================================相对分割线===========================================================

    /**
     * 对应 用户对用户级别  多对一
     *
     * @return void
     */
    public function userLevel()
    {
        return $this->belongsTo(UserLevel::class,'level_id','id');
    }


    /**
     * 定义 一对多 用户对用户实名认证申请
     *
     * @return void
     */
    public function userApplyRealAuth()
    {
        return $this->hasMany(UserApplyRealAuth::class, 'user_id', 'id');
    }

}
