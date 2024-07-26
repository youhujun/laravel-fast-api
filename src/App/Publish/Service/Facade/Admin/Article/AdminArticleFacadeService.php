<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 00:13:17
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 20:23:09
 * @FilePath: \app\Service\Facade\Admin\Article\AdminArticleFacadeService.php
 */

namespace App\Service\Facade\Admin\Article;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Service\Facade\Trait\QueryService;

use App\Exceptions\Admin\CommonException;
use App\Events\Admin\CommonEvent;

use App\Events\Admin\Article\AddArticleEvent;
use App\Events\Admin\Article\UpdateArticleEvent;

use App\Jobs\Admin\Article\AddArticleJob;

use App\Models\Article\Article;
use App\Models\Admin\Admin;

use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\ArticleCollection;

/**
 * @see \App\Facade\Admin\Article\AdminArticleFacade
 */
class AdminArticleFacadeService
{
   public function test()
   {
       echo "AdminArticleFacadeService test";
   }

   use QueryService;

    protected static $sort = [
      '4'=>['created_time','desc'],
      '3'=>['created_time','asc'],
      '2'=>['published_time','desc'],
      '1'=>['published_time','asc']
    ];

    /**
     * 获取文章
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function getArticle($validated,$admin)
    {
        $result = code(config('admin_code.GetArticleError'));

        $this->setQueryOptions($validated);

        $this->withWhere = ['articleInfo','admin','user','admin.user.userInfo','user.userInfo','category','label'
           ];

        $query = Article::with($this->withWhere);

        if(isset($validated['categoryArray']) && count($validated['categoryArray']))
        {
            $query->whereHas('category',function(Builder $withQuery)use($validated){
                    $withQuery->whereIn('category_id',$validated['categoryArray']);
                   });

        }

         if(isset($validated['LabelArray']) && count($validated['LabelArray']))
        {
            $query->whereHas('label',function(Builder $withQuery)use($validated){
                    $withQuery->whereIn('label_id',$validated['labelArray']);
                   });
        }


        //普通管理员查询自己的文章

        if(!$admin->isDevelop() && !$admin->isSuper())
        {
            $this->where[] = ['admin_id','=',$admin->id];
        }

        //置顶
        if(isset($validated['is_top']))
        {
            $this->where[] = ['is_top','=',$validated['is_top']];
        }

        //发布状态
        if(isset($validated['status']))
        {
            $this->where[] = ['status','=',$validated['status']];
        }

        //标题查找
        if(isset($validated['find']))
        {
            $this->where[] = ['title','like',"%{$validated['find']}%"];
        }

        $query->where($this->where);

        //发布时间
        if(isset($validated['timeRangePublish']) && \count($validated['timeRangePublish']))
        {
             $this->whereBetween[0][] = strtotime($validated['timeRangePublish'][0]);
             $this->whereBetween[0][] = strtotime($validated['timeRangePublish'][1]);

             $query->whereBetween('published_time' ,$this->whereBetween[0]);
        }

        //创建时间
        if(isset($validated['timeRangeCreate']) && \count($validated['timeRangeCreate']))
        {
             $this->whereBetween[1][]  = strtotime($validated['timeRangeCreate'][0]);
             $this->whereBetween[1][]  = strtotime($validated['timeRangeCreate'][1]);

             $query->whereBetween('created_time', $this->whereBetween[1]);
        }

        //排序
        if(isset($validated['sortType']))
        {
             $sortType = $validated['sortType'];

             $query->orderBy(self::$sort[$sortType][0],self::$sort[$sortType][1]);
        }

        $articleList = $query->paginate($this->perPage,$this->columns,$this->pageName,$this->page);

        if(!optional($articleList))
        {
           throw new CommonException('GetArticleError');
        }

        $result= new ArticleCollection($articleList,['code'=>0,'msg'=>'获取文章列表成功']);

        return $result;

    }
    /**
     * 添加文章
     *
     * @param [type] $validated 表单验证完成的参数
     * @param [type] $admin 当前操作的用户
     * @return void
     */
    public function addArticle($validated,$admin)
    {
        $result = code(config('admin_code.AddArticleError'));

        //添加文章
        $article = new Article();

        $article->created_at = \time();

        $article->created_time = \time();

        $article->admin_id = $admin->id;

        $article->title = $validated['title'];

        $article->is_top = $validated['is_top'];

        $article->sort = $validated['sort'];

        $article->type = $validated['type'];

        $article->category_id = json_encode($validated['category_id']);

        if(isset($validated['label_id']))
        {
            $article->label_id = json_encode($validated['label_id']);
        }

        //默认已发布
        $article->status = 10;

        $article->published_at = time();

        $article->published_time = time();

        if(isset($validated['published_time']) && !empty($validated['published_time']))
        {
            $article->published_at = \strtotime($validated['published_time']);
            $article->published_time = \strtotime($validated['published_time']);

            if($article->published_time > time())
            {
                //如果发布时间 大于 现在时间 发布状态改为0 未发布
                 $article->status = 0;
            }
        }

        $articleResult = $article->save();

        if(!$articleResult)
        {
           throw new CommonException('AddArticleError');
        }

        AddArticleEvent::dispatch($admin,$article,$validated);

        CommonEvent::dispatch($admin,$validated,'AddArticle');

        AddArticleJob::dispatchIf($article->status === 0,$admin,$article)->delay(now()->addSeconds($article->published_time - time()));

        $result = code(['code'=>0,'msg'=>'文章添加成功!']);

        return $result;
    }


    /**
     * 更新文章
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function updateArticle($validated,$admin)
    {
        $result = code(config('admin_code.UpdateArticleError'));

        $articleId = $validated['id'];

        $article = Article::find($articleId);

        if(!$article)
        {
            throw new CommonException('ThisDataNotExistsError');
        }


        $revision = $article->revision;

        $updateWhere = ['id'=>$articleId,'revision'=>$revision];

        $update = [
            'title'=>$validated['title'],
            'sort'=>$validated['sort'],
            'type'=>$validated['type'],
            'is_top'=>$validated['is_top'],
            'category_id'=>json_encode($validated['category_id']),
            'updated_at'=>date('Y-m-d H:i:s',time()),
            'updated_time'=>time(),
            'revision' => $revision + 1
        ];

        if(isset($validated['label_id']))
        {
            $update['label_id'] = json_encode($validated['label_id']);
        }

        if(isset($validated['published_time']) && !empty($validated['published_time']))
        {
            $update['published_at'] = $validated['published_time'];
            $update['published_time'] = \strtotime($validated['published_time']);

            if($article->published_time > time())
            {
                //如果发布时间 大于 现在时间 发布状态改为0 未发布
                 $update['status'] = 0;
            }
        }


        $articleResult = Article::where($updateWhere)->update( $update);

        if(!$articleResult)
        {
            throw new CommonException('UpdateArticleError');
        }

        UpdateArticleEvent::dispatch($admin,$article,$validated);

        CommonEvent::dispatch($admin,$validated,'UpdateArticle');

        AddArticleJob::dispatchIf($article->status === 0,$admin,$article)->delay(now()->addSeconds($article->published_time - time()));


        $result = code(['code'=>0,'msg'=>'文章更新成功!']);

        return $result;
    }


    /**
     * 置顶文章
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function toTopArticle($validated,$admin)
    {
        $result = code(config('admin_code.TopArticleError'));

        $article = Article::find($validated['id']);

        if(!$article)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $revision = $article->revision;

        $updateData = [
            'is_top'=>1,
            'revision'=>$revision + 1,
            'updated_at'=>date('Y-m-d H:i:s',time()),
            'updated_time'=>time()
        ];

        $updateWhere = [
            'id'=>$validated['id'],
            'revision'=>$revision
        ];

        $updateReuslt = Article::where($updateWhere)->update( $updateData);

        if(!$updateReuslt)
        {
            throw new CommonException('TopArticleError');
        }

        CommonEvent::dispatch($admin,$validated,'ToTopArticle');

        $result = code(['code'=>0,'msg'=>'置顶文章成功!']);

        return $result;
    }

    /**
     * 批量置顶
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleToTopArticle($validated,$admin)
    {
        $result = code(config('admin_code.MultipleTopArticleError'));

        $updateData = ['is_top'=> 1];

        $updateResult = Article::whereIn('id',$validated['selectId'])->update( $updateData );

        if(!$updateResult)
        {
            throw new CommonException('MultipleTopArticleError');
        }

        CommonEvent::dispatch($admin,$validated,'MultipleTopArticle');

        $result = code(['code'=>0,'msg'=>'批量置顶文章成功!']);

        return $result;
    }

    /**
     * 批量取消置顶
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleUnTopArticle($validated,$admin)
    {
        $result = code(config('admin_code.MultipleUnTopArticleError'));

        $updateData = ['is_top'=> 0];

        $updateResult = Article::whereIn('id',$validated['selectId'])->update($updateData );

        if(!$updateResult)
        {
            throw new CommonException('MultipleUnTopArticleError');
        }

        CommonEvent::dispatch($admin,$validated,'MultipleUnTopArticle');

        $result = code(['code'=>0,'msg'=>'批量取消置顶文章成功!']);

        return $result;
    }

    /**
     * 删除文章
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function deleteArticle($validated,$admin)
    {
        $result = code(config('admin_code.DeleteArticleError'));

        $article = Article::find($validated['id']);

        if(!$article)
        {
            throw new CommonException('ThisDataNotExistsError');
        }

        $article->deleted_at = date('Y-m-d H:i:s',time());

        $deleteReuslt = $article->save();

        if(! $deleteReuslt)
        {
            throw new CommonException('DeleteArticleError');
        }

        CommonEvent::dispatch($admin,$validated,'DeleteArticle');

        $result = code(['code'=>0,'msg'=>'删除文章成功!']);

        return $result;
    }

    /**
     * 批量删除
     *
     * @param [type] $validated
     * @param [type] $admin
     * @return void
     */
    public function multipleDeleteArticle($validated,$admin)
    {
        $result = code(config('admin_code.MultipleDeleteArticleError'));

        $deleteResult = Article::whereIn('id',$validated['selectId'])->delete();

        if(!$deleteResult)
        {
            throw new CommonException('MultipleDeleteArticleError');
        }

        CommonEvent::dispatch($admin,$validated,'MultipleDeleteArticle');

        $result = code(['code'=>0,'msg'=>'批量删除文章成功!']);

        return $result;
    }
}
