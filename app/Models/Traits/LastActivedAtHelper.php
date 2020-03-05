<?php
namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    //缓存相关
    protected $hash_prefix = 'larabbs_last_active_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {
        // 获取今天的日期
        $data = Carbon::now()->toDateString();

        // Redis 哈希表名，如：larabbs_last_active_at_2020_03_05
        $hash = $this->hash_prefix . $data;

        // 字段名称，如user_1;
        $field = $this->field_prefix . $this->id;
        dd(Redis::hGetAll($hash));
        //当前时间
        $now = Carbon::now()->toDateString();

        //数据写入 Redis, 字段存在，会被更新
        Redis::hSet($hash, $field, $now);
    }
}