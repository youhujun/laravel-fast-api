<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-04-23 11:13:16
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-04-06 20:48:45
 */

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\User\User;
use App\Models\Picture\AlbumPicture;
use App\Models\System\Bank\Bank;

class UserBank extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'user_bank';
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





    /**
     * 定义 相对 一对多 用户对银行卡
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    /**
     * 定义 相对 一对多 银行对用户银行卡
     *
     * @return void
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class,'bank_id','id');
    }

    /**
     * 定义相对 一对一 银行卡正面
     *
     * @return void
     */
    public function bankFront()
    {
        return $this->belongsTo(AlbumPicture::class,'bank_front_id','id');
    }

    /**
     * 定义相对 一对一 银行卡背面
     *
     * @return void
     */
    public function bankBack()
    {
        return $this->belongsTo(AlbumPicture::class,'bank_back_id','id');
    }

}
