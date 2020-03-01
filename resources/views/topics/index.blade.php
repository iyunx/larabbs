@extends('layouts.app')
@section('title', '话题列表')
@section('content')

<div class="row md-4">
  <div class="col-lg-9 col-md-9 topics_list">
    <div class="card">
      <div class="card-header bg-transparent">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#">最新话题</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">最新回复</a>
            </li>
        </ul>
      </div>
      <div class="card-body">
        @include('topics._topic_list', $topics)
        
        <div class="mt-4">
          {!!$topics->links()!!}
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-3 mb-4">
    @include('topics._sidebar')
  </div>
</div>

@endsection