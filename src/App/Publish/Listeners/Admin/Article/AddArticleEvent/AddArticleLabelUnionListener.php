<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 13:12:38
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 13:45:13
 * @FilePath: \app\Listeners\Admin\Article\AddArticleEvent\AddArticleLabelUnionListener.php
 */

namespace App\Listeners\Admin\Article\AddArticleEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Article\Union\ArticleLabelUnion;

/**
 * @see \App\Events\Admin\Article\AddArticleEvent
 */
class AddArticleLabelUnionListener
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

         //添加文章标签关联
        $articlelabelUnionResult = 1;

        if(isset($validated['labelArray']))
        {
            $articleLabelUnion = new ArticleLabelUnion();

            $labelData = [];

            foreach($validated['labelArray'] as $key => $value)
            {
                $labelData[] = ['created_at'=>time(),'created_time'=>time(),'article_id'=>$article->id,'label_id'=>$value];
            }

            $articlelabelUnionResult = $articleLabelUnion->insert($labelData);
        }

        if(!$articlelabelUnionResult)
        {
            if($isTransation)
            {
                 DB::rollBack();
            }

            throw new CommonException('AddArticleLabelError');
        }

    }
}
