<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 12:59:27
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-11 08:10:11
 * @FilePath: \app\Events\Admin\Article\AddArticleEvent.php
 */


namespace App\Events\Admin\Article;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Admin\Admin;
use App\Models\Article\Article;

/**
 * @see \App\Listeners\Admin\Article\AddArticleEvent\AddArticleInfoListener
 * @see \App\Listeners\Admin\Article\AddArticleEvent\AddArticleCategoryUnionListener
 * @see \App\Listeners\Admin\Article\AddArticleEvent\AddArticleLabelUnionListener
 */
class AddArticleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $admin;
    public $article;
    public $validated;
    //是否开启事务
    public $isTransation;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Admin $admin,Article $article,$validated,$isTransation = 0)
    {
        $this->admin = $admin;
        $this->article = $article;
        $this->validated = $validated;
        $this->isTransation = $isTransation;
    }

    /**
     * 广播事件名称
     *
     * @return string
     */
     public function broadcastAs()
    {
        return 'add.article';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
        return new Channel('article');
    }
}
