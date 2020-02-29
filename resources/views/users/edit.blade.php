@extends('layouts.app')
@section('title', $user->name . '编辑')
@section('content')
<div class="col-md-8 offset-md-2">
    <div class="card">
        <div class="card-header">
            <h4>编辑个人资料</h4>
        </div>
        <div class="card-body">
            <form action="{{route('users.update', $user->id)}}" method="post" enctype="multipart/form-data">
                @csrf @method('put')
                <div class="form-group">
                  <label>用户名</label>
                  <input type="text" name="name" value="{{old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>邮箱</label>
                    <input type="text" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="form-group">
                    <label>个人简介</label>
                    <textarea name="introduction" class="form-control" rows="3">{{ old('introduction', $user->introduction) }}</textarea>
                  </div>
                  <div class="form-group mb-4">
                    <label>头像</label>
                    <input type="file" name="avatar" class="form-control-file">
                    @if ($user->avatar)
                        <br>
                        <img src="{{$user->avatar}}" width="200" class="thumbnail img-responsive">
                    @endif
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary">立即修改</button>
                    <a class="btn btn-link" href="{{route('password.request')}}">重置密码</a>
                  </div>
            </form>
        </div>
    </div>
</div>
@endsection