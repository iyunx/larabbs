<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        //XSS过滤
        $topic->body = clean($topic->body, 'user_topic_body');
        //make_excerpt 是全局辅助函数 在 app\helper.php  这里生成简介内容，数据表字段为excerpt
        $topic->excerpt = make_excerpt($topic->body);
        // 如果slug无内容，就使用翻译器翻译，并存储
        if(!$topic->slug){
            //app() 允许我们使用 Laravel 服务容器
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }

    public function updating(Topic $topic)
    {
        //
    }
}