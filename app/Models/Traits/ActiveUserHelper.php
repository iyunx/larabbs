<?php
namespace App\Models\Traits;

use App\Models\Reply;
use App\Models\Topic;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ActiveUserHelper
{
    private $users = [];
    
    private $topic_weight = 4;
    private $reply_weight = 1;
    private $pass_days = 7;
    private $user_number = 7;

    private $cache_key = 'larabbs_active_user';
    private $cache_expire_in_seconds = 65*60;

    public function getActiveUsers()
    {
        //通过key等获取缓存的活跃用户，没有则直接调用
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function(){
            return $this->calculateActiveUsers();
        });
    }

    public function setActiveUsers()
    {
        //将获得的活跃用户，存入缓存
        $active_users = $this->calculateActiveUsers();
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_seconds);
    }

    private function calculateActiveUsers()
    {
        $this->cacheTopicUsers();
        $this->cacheReplyUsers();

        $users = Arr::sort($this->users, function($user){
            return $user['score'];
        });

        $users = array_reverse($users, true);

        $users = array_slice($users, 0, $this->user_number, true);

        $active_users = collect();

        foreach($users as $user_id=>$user){
            $user = $this->find($user_id);

            if($user){
                $active_users->push($user);
            }
        }

        return $active_users;
    }

    private function cacheTopicUsers()
    {
        $topic_users = Topic::query()->select(DB::raw('user_id, count(*) as topic_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();
        // 计算话题得分
        foreach($topic_users as $value){
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
        }
    }

    private function cacheReplyUsers(){
        $reply_users = Reply::query()->select(DB::raw('user_id, count(*) as reply_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();

        // 回复得分
        foreach($reply_users as $value){
            //
            $reply_score = $value->reply_count * $this->reply_weight;
            //用户可能只回复，没话题
            if(isset($this->users[$value->user_id])){
                $this->users[$value->user_id]['score'] += $reply_score;
            } else {
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }
}