<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 13:11:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 13:30:11
 * @FilePath: \app\Listeners\Admin\Article\AddArticleEvent\AddArticleInfoListener.php
 */

namespace App\Listeners\Admin\Article\AddArticleEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Article\ArticleInfo;

/**
 * @see \App\Events\Admin\Article\AddArticleEvent
 */
class AddArticleInfoListener
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

         //添加文章详情
        $articleInfo = new ArticleInfo();

        $articleInfo->created_at = \time();

        $articleInfo->created_time = \time();

        $articleInfo->article_id = $article->id;

        $articleInfo->article_info = $validated['content'];

        $articleInfoResult =  $articleInfo->save();

        if(!$articleInfoResult)
        {
            if($isTransation)
            {
                DB::rollBack();
            }

            throw new CommonException('AddArticleInfoError');
        }

    }
}
