@if (count($topics))
<ul class="list-unstyled">
  @foreach ($topics as $topic)
  <li class="media">
    <div class="media-left">
      <a href="{{route('users.show', $topic->user_id)}}">
        <img class="mr-3 media-object img-thumbnail" src="{{$topic->user->avatar}}" alt="{{$topic->user->name}}" width="53">
      </a>
    </div>
    <div class="media-body">
      <div class="media-heading mb-2 mt-0">
        <a href="{{$topic->link()}}">{{$topic->title}}</a>
        <span class="badge badge-pill badge-secondary float-right">{{ $topic->reply_count }} </span>
      </div>
      <small class="media-body meta text-secondary">
        <a href="{{route('category.show', $topic->category_id)}}" class="text text-secondary"><i class="far fa-folder"></i> {{$topic->category->name}}</a>
        <span> • </span>
        <a href="#" class="text text-secondary"><i class="far fa-user"></i> {{$topic->user->name}}</a>
        <span> • </span>
        @if(if_query('order', 'recent'))
        <a href="#" class="text text-secondary"><i class="far fa-clock"></i> {{$topic->created_at->diffForHumans()}}</a>
        @else
        <a href="#" class="text text-secondary"><i class="far fa-clock"></i> {{$topic->updated_at->diffForHumans()}}</a>
        @endif
        
      </small>
    </div>
  </li>

  @if (!$loop->last)
  <hr>
  @endif
  @endforeach
</ul>
@else
<div>暂无数据</div>
@endif