<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use MustVerifyEmailTrait;
    //默认就调用了，我们这里扩展一下
    use Notifiable {
        //notify是Notifiable中的一个方式，这里重写，别名
        //参考https://www.php.net/manual/en/language.oop5.traits.php#language.oop5.traits.visibility
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        // 如果要通知的是当前用户，就不用通知，本人给本人评论，不用通知
        if($this->id === Auth::id()) return;

        // 只有数据库类型通知才需要通知
        if(method_exists($instance, 'toDatabase')) $this->increment('notification_count');

        $this->laravelNotify($instance);
    }

    //清除未读消息标示
    public function markAsRead()
    {
        //模型中通过$this直接指向数据表字段名
        $this->notification_count = 0;
        $this->save();
        //unreadNotifications是上面 use Notifiable中的方法
        $this->unreadNotifications->markAsRead();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //observer权限策略
    public function isAuthor($model){
        return $this->id == $model->user_id;
    }

    public function topic()
    {
        return $this->hasMany(Topic::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
