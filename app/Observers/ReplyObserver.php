<?php

namespace App\Observers;

use App\Models\Reply;

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
    }

    public function updating(Reply $reply)
    {
        //
    }
}