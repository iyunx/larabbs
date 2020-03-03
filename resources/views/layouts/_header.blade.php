<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    <!-- Branding Image -->
    <a class="navbar-brand " href="{{ url('/') }}">
      LaraBBS
    </a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a class="nav-link @if(Route::is('topics.index')) active @endif" href="{{route('topics.index')}}">话题</a></li>
        @foreach (\App\Models\Category::all() as $category)
        <li class="nav-item">
          <a class="nav-link @if(Route::is('category.show') && Route::input('category')->is($category))active @endif" href="{{route('category.show', $category)}}">{{$category->name}}</a>
        </li>
        @endforeach
      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav navbar-right">
        @auth
        <li class="nav-item">
          <a class="nav-link mt-1 mr-3 font-weight-bold" href="{{ route('topics.create') }}">
            <i class="fa fa-plus"></i>
          </a>
        </li>
        <li class="nav-item notification-badge">
          <a class="nav-link mr-3 badge badge-pill badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white" href="{{ route('notifications.index') }}">
            {{ Auth::user()->notification_count }}
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
          {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{route('users.show', Auth::id())}}">个人中心</a>
          <a class="dropdown-item" href="{{route('users.edit', Auth::id())}}">编辑资料</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" id="logout">
              <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('您确定要退出吗？')">
              @csrf
              <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
              </form>
          </a>
          </div>
      </li>
        @else
        <li class="nav-item"><a class="nav-link" href="{{route('login')}}">登录</a></li>
        <li class="nav-item"><a class="nav-link" href="{{route('register')}}">注册</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
