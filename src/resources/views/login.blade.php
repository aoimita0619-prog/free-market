<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ログイン</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <a class="header__logo" href="/">
        <img src="{{ asset('img/COACHTECH.png') }}" alt="">
      </a>
    </div>
  </header>

  <main>
    <div class="login-form__content">
      <div class="login-form__heading">
        <h2>ログイン</h2>
      </div>
    
      <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        
        <div class="login-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}"  autofocus >
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="login-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" >
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
         <button type="submit">ログインする</button>
      </form>

      <p class="link">
        <a href="{{ route('register') }}">会員登録はこちら</a>
      </p>
    </div>
    
  </main>
</body>

</html>
