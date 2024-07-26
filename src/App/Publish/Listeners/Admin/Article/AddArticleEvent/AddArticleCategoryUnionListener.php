<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 13:12:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 13:44:36
 * @FilePath: \app\Listeners\Admin\Article\AddArticleEvent\AddArticleCategoryUnionListener.php
 */

namespace App\Listeners\Admin\Article\AddArticleEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Article\Union\ArticleCategoryUnion;

/**
 * @see \App\Events\Admin\Article\AddArticleEvent
 */
class AddArticleCategoryUnionListener
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

          //添加文章分类关联
        $articleCategoryUnion = new ArticleCategoryUnion();

        $categoryData = [];

        foreach($validated['categoryArray'] as $key => $value)
        {
            $categoryData[] = ['created_at'=>date('Y-m-d H:i:s',time()),'created_time'=>time(),'article_id'=>$article->id,'category_id'=>$value];
        }

        $articleCategoryUnionResult = $articleCategoryUnion->insert($categoryData);

        if(!$articleCategoryUnionResult)
        {
            if($isTransation)
            {
                DB::rollBack();
            }

            throw new CommonException('AddArticleCategoryError');
        }
    }
}
