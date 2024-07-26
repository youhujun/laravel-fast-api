<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2021-10-18 10:52:41
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-04-06 21:08:19
 */

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Picture\AlbumPicture;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'category';
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

    protected function rate():Attribute
    {
        return new Attribute(
            set:fn($rate) => \bcdiv($rate,100,2),
        );
    }

    /**
     * 对应 文章分类和文章 多对多
     *
     * @return void
     */
    public function article()
    {
        return $this->newBelongsToMany(Article::class,'article_category_union','category_id','article_id');
    }

    /**
     * 想对 多对一 相册图片表
     *
     * @return void
     */
    public function picture()
    {
        return $this->belongsTo(AlbumPicture::class,'category_picture_id', 'id');
    }

}
