<ul class="list-unstyled mt-10">
    @foreach ($replies as $index => $reply)
      <li class=" media" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
        <div class="media-left">
          <a href="{{ route('users.show', [$reply->user_id]) }}">
            <img class="media-object img-thumbnail mr-3" alt="{{ $reply->user->name }}" src="{{ $reply->user->avatar }}" style="width:48px;height:48px;" />
          </a>
        </div>
  
        <div class="media-body">
          <div class="media-heading mt-0 mb-1 text-secondary">
            <a href="{{ route('users.show', $reply->user_id) }}" title="{{ $reply->user->name }}">
              {{ $reply->user->name }}
            </a>

            @can('destroy', $reply)
            <span class="meta float-right ">
              <form action="{{route('replies.destroy', $reply)}}" method="post" onsubmit="return confirm('确定要删除此评论吗？')">
                @csrf @method('delete')
                <button type="submit" class="btn btn-default btn-xs pull-left text-secondary"><i class="far fa-trash-alt"></i></button>
              </form>
            </span>
            @endcan

            <span class="text-secondary"> • </span>
            <span class="meta text-secondary" title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</span>
  
          </div>
          <div class="reply-content text-secondary">
            {!! $reply->content !!}
          </div>
        </div>
      </li>
  
      @if ( ! $loop->last)
        <hr>
      @endif
  
    @endforeach

    <div class="mt-4">{!!$replies->render()!!}</div>
</ul>