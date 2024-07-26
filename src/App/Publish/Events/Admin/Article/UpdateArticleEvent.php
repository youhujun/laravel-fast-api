<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-06-10 14:39:33
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-06-10 14:44:49
 * @FilePath: \app\Events\Admin\Article\UpdateArticleEvent.php
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
 * @see \App\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleInfoListener
 * @see \App\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleCategoryUnionListener
 * @see \App\Listeners\Admin\Article\UpdateArticleEvent\UpdateArticleLabelUnionListener
 */
class UpdateArticleEvent
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
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
