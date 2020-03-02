@extends('layouts.app')
@section('style')
  <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop
@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-header">
        <h2>
          <i class="far fa-edit"></i>
          @if($topic->id)
            编辑话题
          @else
            新建话题
          @endif
        </h2>
      </div>

      <div class="card-body">
        @if($topic->id)
          <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
        @endif

          @include('shared._errors')

          @csrf

                <div class="form-group">
                	<input class="form-control" type="text" name="title" placeholder="请输入标题" value="{{old('title', $topic->title)}}" />
                </div>
                <div class="form-group">
                  <select name="category_id" class="form-control">
                    <option value="" hidden disabled selected>请选择分类</option>
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" {{ $category->id == $topic->category_id ? 'selected' : ''}} >{{$category->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                	<textarea name="body" id="editor" class="form-control simditor-body" rows="6">{{ old('body', $topic->body ) }}</textarea>
                </div> 
          <div class="well well-sm">
            <button type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-link float-xs-right" href="{{ route('topics.index') }}"> <- Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@stop

@section('script')
  <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

  {{-- <script>
    $(document).ready(function() {
      var editor = new Simditor({
        textarea: $('#editor'),
        upload: {
          url: "{{route('topics.upload_image')}}",
          params: { _token: '{{ csrf_token() }}'},
          fileKey: 'upload_file',
          connectionCount: 3,
          leaveConfirm: '文件上传中，关闭此页面将取消上传。'
        },
        pasteImage: true,
        cleanPaste: true,
      });
    });
  </script> --}}
@stop