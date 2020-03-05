<div class="card mb-3">
    <div class="card-body">
        <a href="{{ route('topics.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
            <i class="fas fa-pencil-alt mr-2"></i>  新建帖子
        </a>
    </div>
</div>

@if ($active_users->count())
    <div class="card">
        <div class="card-header" style="font-size:22px">
            活跃用户
        </div>
        <div class="card-body">
            @foreach ($active_users as $active_user)
            <div class="media @if(!$loop->last) mb-3 @endif">
                <a class="d-flex mr-3" href="{{route('users.show', $active_user)}}">
                    <img src="{{$active_user->avatar}}" alt="" width="40">
                </a>
                <div class="media-body">
                    <a href="{{route('users.show', $active_user)}}">{{$active_user->name}}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endif