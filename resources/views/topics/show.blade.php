@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->excerpt)

@section('content')

<div class="row">

  <div class="col-lg-3 col-md-3 mb-3">
    <div class="card ">
      <img class="card-img-top" src="{{$user->avatar}}" alt="{{ $user->name }}">
      <div class="card-body">
            <h5><strong>个人简介</strong></h5>
            <p>{{$user->introduction}}</p>
            <hr>
            <h5><strong>注册于</strong></h5>
            <p>{{$user->created_at->diffForHumans()}}</p>
      </div>
    </div>
  </div>
  <div class="col-lg-9 col-md-9 col-sm-12 topic-content">
    <div class="card ">
      <div class="card-body">
        <h1 class="text-center mt-3 mb-3">
          {{ $topic->title }}
        </h1>
        <div class="article-meta text-center text-secondary">
          {{ $topic->created_at->diffForHumans() }}
          ⋅
          <i class="far fa-comment"></i>
          {{ $topic->reply_count }}
        </div>
        <div class="topic-body mt-4 mb-4">
          {!! $topic->body !!}
        </div>

        <div class="operate">
          <hr>
          <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-outline-secondary btn-sm" role="button">
            <i class="far fa-edit"></i> 编辑
          </a>
          <a href="#" class="btn btn-outline-secondary btn-sm" role="button">
            <i class="far fa-trash-alt"></i> 删除
          </a>
        </div>
        
      </div>
    </div>

  </div>
</div>
@stop