@extends('layouts.app')
@section('title', '我的通知')

@section('content')
<div class="col-md-10 offset-md-1">
<div class="card">
    <div class="card-body">
        <h3 class="card-title">
            <i class="far fa-bell" aria-hidden="true"></i> 我的通知
        </h3>
        <hr>
        @if (count($notifications))
            <ul class="list-unstyled">
                @foreach ($notifications as $notification)
                {{-- $notification->type 获取notifications表中type字段内容：App\Notifications\TopicReplied
                    class_basename()能截取上面末尾：TopicReplied
                    Str::snake() 将上面大写转换成小写，且 中间大小字母前面加 _ : topic_replied
                    Str::snake()为laravel全局辅助函数
                 --}}
                @include('notifications.type_'. Str::snake(class_basename($notification->type)))
                @endforeach
            </ul>
        @else
        <div class="empty-block">没有通知消息</div>
        @endif
    </div>
</div>
</div>
@stop