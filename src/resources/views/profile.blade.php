@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('content')

    <div class="profile-form__content">
      <div class="profile-form__heading">
        <h2>プロフィール設定</h2>
      </div>
      <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"  novalidate>
        @csrf

        <div class="profile-img__area">
            <img id="preview" src="{{ $user->img ? asset('storage/' . $user->img) : '' }}" class="profile-img">
          <label for="img" class="img-upload">
              画像を選択する
          </label>
          <input type="file" name="img" id="img" accept="image/*" hidden>
        </div>
        <script>
            const imageInput = document.getElementById('img');
            const preview = document.getElementById('preview');

            imageInput.addEventListener('change', function (e) {
               const file = e.target.files[0];

              if (!file) {
                 return;
              }

             preview.src = URL.createObjectURL(file);
            });
        </script>

        <div class="profile-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="profile-group">
            <label for="post_code">郵便番号</label>
            <input type="post_code" id="post_code" name="post_code" value="{{ old('post_code', $user->post_code) }}" required>
            @error('post_code')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="profile-group">
            <label for="address">住所</label>
            <input type="address" id="address" value="{{ old('address', $user->address) }}"  name="address" required>
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="profile-group">
            <label for="building">建物名</label>
            <input type="building" id="building" name="building" value="{{ old('building', $user->building) }}" required>
        </div>
        
        <button class= "update__btn" type="submit">更新する</button>
     </form>

   </div>
@endsection