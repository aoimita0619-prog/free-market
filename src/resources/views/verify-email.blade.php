<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>会員登録</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/verify-email.css') }}" />
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
    <div class="verify__content">
        <div class="verify-content__header">
            <p> 登録していただいたメールアドレスに認証メールを送付しました</p>
            <p>メール認証を完了してください。</p>
        </div>
        <div class="verify-content__btn">
            <p>認証はこちらから</p>
        </div>
        <form method="POST" action="{{ route('verification.send') }}">
          @csrf
          <button type="submit">
            認証メールを再送する
          </button>
        </form>
    </div>
  </main>
</body>
</html>