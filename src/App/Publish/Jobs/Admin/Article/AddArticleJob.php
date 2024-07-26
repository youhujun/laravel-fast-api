<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 13:51:41
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 14:06:44
 * @FilePath: \app\Jobs\Admin\Article\AddArticleJob.php
 */

namespace App\Jobs\Admin\Article;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Log;

use App\Jobs\Middleware\RateLimited;

use App\Models\Admin\Admin;
use App\Models\Article\Article;
use PhpParser\Node\Stmt\TryCatch;

class AddArticleJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $admin;
    protected $article;
    /**
     * 任务尝试次数
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 3;

    /**
     * 任务失败前允许的最大异常数
     *
     * @var int
     */
    public $maxExceptions = 3;

    /**
     * 如果任务的模型不再存在，则删除该任务
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;
    /**
     * Create a new job instance.
     */
    public function __construct(Admin $admin,Article $article)
    {
         $this->admin = $admin->withoutRelations();
         $this->article = $article->withoutRelations();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $article = $this->article;

        try {

            $article = Article::find($article->id);

            $articleRevision = $article->revision;

            $articleWhere = [['id','=',$article->id],['revision','=',$articleRevision]];

            $articleUpdate = ['status'=>10,'updated_time'=>time(),'updated_at'=>time(),'revision'=>$articleRevision + 1];

            $articleResult = Article::where($articleWhere)->update( $articleUpdate);

            if($articleResult)
            {
                 Log::debug(['ArticleAutoPublishSuccess'=>'文章自动发布成功!','article_id'=>$article->id]);
            }
            else
            {
                Log::debug(['ArticleAutoPublishError'=>'文章自动发布失败!','article_id'=>$article->id]);
            }

        } catch (\Throwable $th) {
             Log::debug(['error'=>$th]);
        }
    }

    public function middleware()
    {
         return [new RateLimited];
    }
}
