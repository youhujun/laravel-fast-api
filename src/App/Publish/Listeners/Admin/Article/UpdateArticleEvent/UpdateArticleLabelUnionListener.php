<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 14:40:51
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 15:02:08
 * @FilePath: \app\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleLabelUnionListener.php
 */

namespace App\Listeners\Admin\Article\UpdateArticleEvent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Admin\CommonException;

use App\Models\Article\Union\ArticleLabelUnion;

class UpdateArticleLabelUnionListener
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

        if(isset($validated['label_id']) && count($validated['label_id']))
        {

            $articleLabelUion = ArticleLabelUnion::where('article_id',$article->id)->get();

            $articleLabelDeleteResult = 1;

            if($articleLabelUion->count())
            {
                $articleLabelDeleteResult = ArticleLabelUnion::where('article_id',$article->id)->delete();
            }

            if(!$articleLabelDeleteResult)
            {
                if($isTransation)
                {
                    DB::rollBack();
                }

                throw new CommonException('UpdateArticleLabelError');
            }

            $labelData = [];

            foreach($validated['labelArray'] as $key => $value)
            {
                    $labelData[] = ['created_at'=>date('Y-m-d H:i:s',time()),'created_time'=>time(),'article_id'=>$article->id,'label_id'=>$value];
            }

            $articleLabelResult = ArticleLabelUnion::insert($labelData);

            if(!$articleLabelResult)
            {
                if($isTransation)
                {
                    DB::rollBack();
                }

                throw new CommonException('UpdateArticleLabelError');
            }

        }
    }
}
