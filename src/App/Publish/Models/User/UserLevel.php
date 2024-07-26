<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\System\Level\LevelItem;

use App\Models\Picture\AlbumPicture;

use App\Models\User\User;

class UserLevel extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

    public $timestamps = false;
    protected $table = 'user_level';
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

    protected function amount():Attribute
    {
        return new Attribute(
            get:fn($amount) => number_format($amount,2,'.','')
        );
    }

     /**
     * 定义 多对多  用户级别对级别配置项
     *
     * @return void
     */
    public function levelItem()
    {
        return $this->belongsToMany(LevelItem::class, 'user_level_item_union', 'user_level_id','level_item_id')->as('userLevelItemValue')->withPivot('value','value_type','id','sort')->withPivotValue('deleted_time',0);
    }

    /**
     * 一对多用 用户级别对用户
     */
    public function user()
    {
        return $this->hasMany(User::class,'level_id','id');
    }

    /**
     * 定义 相对 多对一
     *
     * @return void
     */
    public function background()
    {
        return $this->belongsTo(AlbumPicture::class, 'background_id', 'id');
    }

}
