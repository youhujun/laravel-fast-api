<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-01-04 13:01:56
 * @LastEditors: YouHuJun
 * @LastEditTime: 2022-12-01 17:37:07
 */

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;


class ArticleInfo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'article_info';
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



    protected function articleInfo():Attribute
    {
        return new Attribute(

            get:fn($value) => htmlspecialchars_decode($value),
        );
    }


    /**
     * 对应  文章详情和文章 一对一
     *
     * @return void
     */
    public function article()
    {
        return $this->belongsTo(Article::class,'article','id');
    }

}
