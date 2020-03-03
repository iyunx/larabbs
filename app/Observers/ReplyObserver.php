<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        // 防止XXS攻击，config 
        $reply->content = clean($reply->content, 'default');
    }
    public function created(Reply $reply)
    {
        // $reply->topic->increment('reply_count', 1); increment加1
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();

        //通知话题作者，有新的评论
        $reply->topic->user->notify(new TopicReplied($reply));
    }

    public function deleted(Reply $reply)
    {
        //重新统计，当前文章评论总数，并保存更新
        $reply->topic->reply_count = $reply->topic->replies->count();
        $reply->topic->save();
    }
}