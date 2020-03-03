@extends('layouts.app')
@section('title', isset($category)?$category->name:'话题列表')
@section('content')

<div class="row md-4">
  <div class="col-lg-9 col-md-9 mb-3 topics_list">
    @if(isset($category))
      <div class="alert alert-primary" role="alert">
        <strong>{{$category->name}} : {{$category->description}}</strong>
      </div>
    @endif
    <div class="card">
      <div class="card-header bg-transparent">
        <ul class="nav nav-pills">
            <li class="nav-item">
              <a class="nav-link {{ active_class( if_query('order', null)) }}" href="{{Request::url()}}">最后回复</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ active_class(if_query('order', 'recent')) }}" href="{{ Request::url() }}?order=recent">最新发布</a>
            </li>
        </ul>
      </div>
      <div class="card-body">
        @include('topics._topic_list', $topics)
        
        <div class="mt-4">
          {!! $topics->appends(Request::except('page'))->render() !!}
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-3 col-md-3 mb-4">
    @include('topics._sidebar')
  </div>
</div>

@endsection