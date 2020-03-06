<?php

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait aaa
{
    private $hash_prefix = 'larabbs_last_active_at_';
    private $field_prefix = 'user_';

    //通过中间件，获取当前用户信息，并传递到这里，用$this接受
    public function setLastActivedAt()
    {
        // toDateString()当前日期 2020-03-06
        $date = Carbon::now()->toDateString();
        $hash = $this->hash_prefix . $date;

        //组合结果是uers_id,,, 这里是接受的当前登录用户的id
        $field = $this->field_prefix . $this->id;

        // 设定最后登录时间，toDateTimeString() 精确到秒：2020-03-06 13：06：40
        $now = Carbon::now()->toDateTimeString();

        //Redis::hSet(关键字, 键, 值);
        //通过关键字，查到对应的键值数组
        Redis::hSet($hash, $field, $now);

    }

    //将缓存的最后登录时间，同步到数据库
    //通过make:command 新建命令行，通过命令行上级kernel.php设定执行时间
    public function syncLastActivedAt()
    {
        //我们设定每天00:00将缓存最后登录时间，更新到数据库
        $yesterday_date = Carbon::yesterday()->toDateString();

        //通过上面的日期，找到对应的关键字，然后找到对于的数组
        $hash = $this->hash_prefix . $yesterday_date;

        //通过关键字，找到数组
        $datas = Redis::hGetAll($hash);

        //以上可能是多个用户，一天的登录，最后时间的，数组组合，便利
        foreach($datas as $user_id=>$actived_at){
            //将键$user_id拆分成仅 id;
            $id = str_replace($this->field_prefix, '', $user_id);
            if($user = $this->find($id)){
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        //以上将缓存，同步到数据，这里就清理缓存, 释放内存
        Redis::del($hash);

    }

    //前端通过get...驼峰...Attribute 可以自动识别获取
    //前端调用数据库数据，优先通过这里查询
    public function getLastActivedAtAttribute($value)
    {
        //通过关键字获取，redis中的缓存

        //先获取今天的日期，昨日关键字日期缓存已经被删除
        $now = Carbon::now()->toDateString();

        //组合关键字
        $hash = $this->hash_prefix . $now;

        //组合当前用户的，字段名称
        $field = $this->field_prefix . $this->id;

        //通过关键字和当前用户的字段名称，查询此用户在缓存中是否有最后登录时间
        //三元，如果有直接调用缓存的最后登录时间，否则调用
        $date_time = Redis::hGet($hash, $field) ?? $value;
    }
}