<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;

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
        // 这里有个问题，如果百度api翻译延迟，会影响会员 话题 的发布等。。。 故推荐job 后台任务模式，再下方方法 saved
        if(!$topic->slug){
            //app() 允许我们使用 Laravel 服务容器 这里同步执行
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }

    // public function saved(Topic $topic)
    // {
    //     //make:job
    //     //异步，都需要有id, 新增没有id, 故保存后，在异步
    //     //异步，保存后，再翻译，并保存
    //     if(!$topic->slug){
    //         //队列模式，make:job 异步后台任务
    //         dispatch(new TranslateSlug($topic));
    //     }
    // }

    public function deleted(Topic $topic)
    {
        //模型监听器中，注意避免再次触发 Eloquent 事件，以免造成联动逻辑冲突。
        //直接DB删除，直接
        DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}