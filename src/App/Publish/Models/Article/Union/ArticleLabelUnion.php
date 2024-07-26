<?php
/*
 * @Descripttion:
 * @version:
 * @Author: YouHuJun
 * @Date: 2022-01-04 13:02:35
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-05-26 20:42:29
 */

namespace App\Models\Article\Union;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ArticleLabelUnion extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'article_label_union';
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

    protected function deletedAt():Attribute
    {
        return new Attribute(

            set:fn($time) => date('Y-m-d H:i:s',$time),
        );
    }
}
