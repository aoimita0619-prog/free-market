<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>COACHTECH</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
  @yield('css')
</head>

<body>
  <header class="header">
     <div class="header__inner">
      <a class="header__logo" href="/">
        <img src="{{ asset('img/COACHTECH.png') }}" alt="">
      </a>
      <form action="{{ route('search') }}" method="GET">
        <input type="text" class="search__form" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
        
        @if(request('tab') === 'mylist')
          <input type="hidden" name="tab" value="mylist">
        @endif
      </form>
   @auth 
    @if (Auth::user()->hasVerifiedEmail())
      <form method='POST' action="{{ route('logout') }}">
        @csrf 
        <button type="submit" class="log-btn">ログアウト</button>
      </form>
      <p class="mypage__link">
        <a href="{{ route('mypage') }}">マイページ</a>
     </p>
     <p class="sell__link">
        <a href="{{ route('sell') }}">出品</a>
     </p>
    @else
      <form method='POST' action="{{ route('logout') }}">
        @csrf 
        <button type="submit" class="log-btn">ログアウト</button>
      </form>
      <p class="mypage__link">
        <a href="{{ route('mypage') }}">マイページ</a>
     </p>
     <p class="sell__link">
        <a href="{{ route('sell') }}">出品</a>
     </p>
    @endif
    @else
      <p class="login-btn">
        <a href="{{ route('login') }}">ログイン</a>
      </p>
      <p class="mypage__link">
        <a href="{{ route('login') }}">マイページ</a>
      </p>
     <p class="sell__link">
        <a href="{{ route('login') }}">出品</a>
     </p>
  @endauth

    </div>
  </header>
  <main>
   @yield('content')
  </main>


</body>

</html>