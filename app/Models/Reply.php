<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    //一个留言只能属于一个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //一个留言只能属于一个话题
    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
}
