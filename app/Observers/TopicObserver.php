<?php

namespace App\Observers;

use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        //make_excerpt 是全局辅助函数 在 app\helper.php
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function updating(Topic $topic)
    {
        //
    }
}