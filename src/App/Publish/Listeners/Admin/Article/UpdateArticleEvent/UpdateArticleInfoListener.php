<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 14:40:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 14:43:07
 * @FilePath: \app\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleInfoListener.php
 */

namespace App\Listeners\Admin\Article\UpdateArticleEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Article\ArticleInfo;

/**
 * @see \App\Events\Admin\Article\UpdateArticleEvent
 */
class UpdateArticleInfoListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

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

        $articleInfo = ArticleInfo::where('article_id',$article->id)->first();

        $updateInfo = ['revision' => $articleInfo->revision + 1,'article_info' =>$validated['content'] ];
        $updateInfoWhere = ['article_id'=>$article->id,'revision'=> $articleInfo->revision];

        $articleInfoReuslt = ArticleInfo::where($updateInfoWhere)->update($updateInfo);

        if(!$articleInfoReuslt)
        {
            if($isTransation)
            {
                 DB::rollBack();
            }

            throw new CommonException('UpdateArticleInfoError');
        }
    }
}
