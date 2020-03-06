<?php
namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    //缓存相关
    protected $hash_prefix = 'larabbs_last_active_at_';
    protected $field_prefix = 'user_';

    //注意这里通过新建的中间件，只要登录就调用此方法，更新登录时间缓存
    //将当前登录用户的登录时间，写入Redis缓存
    // dd($this->toArray()); 可以获取当前登录用户全部信息
    public function recordLastActivedAt()
    {
        // 获取今天的日期
        $data = Carbon::now()->toDateString();
        
        // Redis 哈希表名，如：larabbs_last_active_at_2020_03_05
        $hash = $this->hash_prefix . $data;

        // 字段名称，如user_1;
        $field = $this->field_prefix . $this->id;
        
        //当前时间
        $now = Carbon::now()->toDateTimeString();
        
        //数据写入 Redis, 字段存在，会被更新
        Redis::hSet($hash, $field, $now);
    }

    //将缓存中的登录时间，同步到数据库，并删除缓存
    public function syncUserActivedAt()
    {
        $yesterday_date = Carbon::yesterday()->toDateString();

        $hash = $this->hash_prefix . $yesterday_date;

        $datas = Redis::hGetAll($hash);

        //遍历，同步到数据库中
        foreach($datas as $user_id=>$actived_at){
            //会将user_id转换成最后的id
            //str_replace(a, c, ab); 替换，c替换ab中的a 结果为cb
            //$this->field_prefix = user_ 从未被赋值
            $user_id = str_replace($this->field_prefix, '', $user_id);

            // 只有当用户存在时才更新到数据库中
            if($user = $this->find($user_id)){
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        //以上redis缓存同步到数据库后，删除redis
        Redis::del($hash);
    }

    // 自定义的 访问器
    //前端获取用户最后登录时间，先通过缓存获取登录时间，如果没有，就通过数据库获取
    //固定写法：get...驼峰(数据表对应字段名)...Attribute($value)
    // getLastActivedAtAttribute（$value） $value也是固定写法
    // get..last_actived_at..Attribute（$value）  last_actived_at为表字段名
    public function getLastActivedAtAttribute($value)
    {
        // 获取今天的日期
        $data = Carbon::now()->toDateString();

        // Redis的哈希表命名
        $hash = $this->hash_prefix . $data;

        //字段名称
        $field = $this->field_prefix . $this->id;

        // 判断缓存中是否有，没有就调用数据库的最后登录时间
        $date_time = Redis::hGet($hash, $field) ?? $value;

        // 如果存在的话，返回时间对应的 Carbon 实体
        if($date_time){
            return new Carbon($date_time);
        }

        //如果以上，数据库和缓存都没有最后登录时间，就用注册时间
        return $this->created_at;
    }
}