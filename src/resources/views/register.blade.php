<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>会員登録</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
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
    <div class="register-form__content">
      <div class="register-form__heading">
        <h2>会員登録</h2>
      </div>
      <form method="POST" action="{{ route('register') }}" novalidate>
        @csrf
        
        <div class="register-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" >
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="register-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" >
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="register-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" >
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="register-group">
            <label for="password_confirmation">確認用パスワード</label>
            <input type="password" id="password_confirmation" name="password_confirmation" >
        </div>
        
        <button type="submit">登録する</button>
     </form>
     <p class="link">
        <a href="{{ route('login') }}">ログインはこちら</a>
     </p>
   </div>
  </main>
</body>

</html>
