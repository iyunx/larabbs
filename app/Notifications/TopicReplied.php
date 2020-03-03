<?php

namespace App\Notifications;

use App\Models\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TopicReplied extends Notification
{
    use Queueable;

    private $reply;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];
        //通知方式有多种，这里通过数据库传播
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        // 数据库['database']通知, 固定写法 toDatabase()
        // toDatabase()返回数组，以json方式写入数据库对应表data字段中
        // 用户留言数据写入通知数据表的data字段中
        return [
            'reply_id' => $this->reply->id,
            'reply_content' => $this->reply->content,
            'user_id' => $this->reply->user->id,
            'user_name' => $this->reply->user->name,
            'user_avatar' => $this->reply->user->avatar,
            'topic_id' => $this->reply->topic->id,
            'topic_title' => $this->reply->topic->title,
            'topic_link' => $this->reply->topic->link(['#reply' . $this->reply->id]), //注意这里是拼接，如评论的id=555, 拼接结果 #reply555 
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
