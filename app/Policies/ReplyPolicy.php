<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    public function destroy(User $user, Reply $reply)
    {
        //评论删除，当前评论的本人，或者 当前话题的作者
        return $reply->user_id == $user->id || $user->id == $reply->topic->user_id;
    }
}
