<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 14:40:36
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 14:58:24
 * @FilePath: \app\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleCategoryUnionListener.php
 */

namespace App\Listeners\Admin\Article\UpdateArticleEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Article\Union\ArticleCategoryUnion;

class UpdateArticleCategoryUnionListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $admin = $event->admin;
        $validated = $event->validated;
        $article = $event->article;
        $isTransation = $event->isTransation;

        $articleCategoryDeleteResult = ArticleCategoryUnion::where('article_id',$article->id)->delete();

        if(!$articleCategoryDeleteResult)
        {
            if($isTransation)
            {
                 DB::rollBack();
            }

            throw new CommonException('ResetArticleCategoryError');
        }

        $categoryData = [];

        foreach($validated['categoryArray'] as $key => $value)
        {
                $categoryData[] = ['created_at'=>date('Y-m-d H:i:s',time()),'created_time'=>time(),'article_id'=>$article->id,'category_id'=>$value];
        }

        $articleCategoryResult = ArticleCategoryUnion::insert($categoryData);

        if(!$articleCategoryResult)
        {
            if($isTransation)
            {
                 DB::rollBack();
            }

            throw new CommonException('UpdateArticleCategoryError');
        }
    }
}
