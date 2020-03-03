<div class="media">
    <a class="d-flex" href="{{route('users.show', $notification->data['user_id'])}}">
        <img class="img-thumbnail mr-3" src="{{$notification->data['user_avatar']}}" alt="{{$notification->data['user_name']}}" style="width:48px;height:48px;">
    </a>
    <div class="media-body">
        <span class="float-right"><i class="far fa-clock"></i> {{$notification->created_at->diffForHumans()}}</span>
        <h6><a href="{{route('users.show', $notification->data['user_id'])}}">{{$notification->data['user_name']}}</a> 评论了您的 
            <a href="{{route('topics.show', $notification->data['topic_id'])}}">{{$notification->data['topic_title']}}</a>
        </h6>
        <a href="{{$notification->data['topic_link']}}">{!!$notification->data['reply_content']!!}</a>
    </div>
</div>