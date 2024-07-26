<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-04-06 20:42:30
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 15:36:25
 * @FilePath: \app\Models\Article\Article.php
 */

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

use App\Models\Admin\Admin;
use App\Models\User\User;
use App\Models\Article\ArticleInfo;
use App\Models\Article\Category;
use App\Models\Help\Label;

class Article extends Model
{
    use HasFactory,SoftDeletes;

    public $timestamps = false;
    protected $table = 'article';
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



    protected function publishedAt():Attribute
    {
        return new Attribute(

            set:fn($time) => date('Y-m-d H:i:s',$time),
        );
    }


    /**
     * 定义文章和文章详情  一对一
     *
     * @return void
     */
    public function articleInfo()
    {
        return $this->hasOne(ArticleInfo::class,'article_id','id');
    }



    /**
     * 定义 文章和文章分类 多对多
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsToMany(Category::class,'article_category_union','article_id','category_id')->wherePivot('deleted_at',null);
    }

    /**
     * 定义 文章和文章分类 多对多
     *
     * @return void
     */
    public function label()
    {
        return $this->belongsToMany(Label::class,'article_label_union','article_id','label_id')->wherePivot('deleted_at',null);
    }

    /**
     * 对应 文章和用户 多对一
     *
     * @return void
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id','id');
    }

    /**
     * 对应 文章和用户 多对一
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
