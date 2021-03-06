<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    //友好slug, 利于seo laravel-china教程2，6.8
    // 参数 $params 允许附加 URL 参数的设定。
    public function link($params=[])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
    // 以下两种排序，使用了本地作用域，前缀：scope
    // 调用时不用前缀，如 去掉 scope 两种排序 recent() recentReplied()
    public function scopeWithOrder($query, $order)
    {
        if($order == 'recent'){
            return $query->recent();
        }
        return $query->recentReplied();
    }

    public function scopeRecentReplied($query)
    {
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }
}
