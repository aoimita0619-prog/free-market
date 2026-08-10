@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('content')
    <div class="sell-form__content">
      <div class="sell-form__heading">
        <h2>商品の出品</h2>
      </div>
      <form method="POST" action="{{ route('item.store') }}" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="sell__img">
            <p class="item__img">商品画像</p>
            <div class="sell-img__area">
              <img id="preview" src="" style="display:none;">
              <label for="img" class="img-upload">
                画像を選択する
              </label>
              <input type="file" name="img" id="img" accept="image/*" hidden>
            </div>
        </div>
        <script>
          const imageInput = document.getElementById('img');
          const preview = document.getElementById('preview');
          const uploadLabel = document.querySelector('.img-upload');

          imageInput.addEventListener('change', function (e) {
                 const file = e.target.files[0];

                 if (!file) {
                     return;
                  }

                 preview.src = URL.createObjectURL(file);
                 preview.style.display = "block";
                 uploadLabel.style.display = "none";
          });

          preview.addEventListener('click', function () {
                 imageInput.click();
          });
        </script>

        <div class="sail__category">
          <h3>商品の詳細</h3>
          <hr>

          <div class="sell-category__group">
            <label for="category">カテゴリー</label>
            <div class="category__list">
            @foreach ($categories as $category)
              <label class="category-tag" >
                <input type="checkbox" name="category_id[]" value="{{ $category->id }}" readonly />
                <span class="category__name">{{ $category['content'] }}</span>
              </label>
            @endforeach
            </div>
            @error('category_id')
                <p class="error">{{ $message }}</p>
            @enderror
          </div>
        
          <div class="sell-category__group">
            <label for="brand">商品の状態</label>
            <select name="condition_id" >
                <option value="" disabled selected>選択してください</option>
                @foreach($conditions as $condition)
                  <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{ $condition['condition'] }}</option>
                @endforeach
            </select>
            @error('condition_id')
                <p class="error">{{ $message }}</p>
            @enderror
          </div>
        </div>


      <div class="sail__detail">
          <h3>商品名と説明</h3>
          <hr>

          <div class="sell-detail__group">
            <label for="name">商品名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
          </div>
        
          <div class="sell-detail__group">
            <label for="brand">ブランド名</label>
            <input type="text" id="brand" name="brand" value="{{ old('brand') }}" required>
            @error('brand')
                <p class="error">{{ $message }}</p>
            @enderror
          </div>
        
          <div class="sell-detail__group">
            <label for="detail">商品の説明</label>
            <textarea type="text" id="detail" name="detail" class="detail">{{ old('detail') }}</textarea>
            @error('detail')
                <p class="error">{{ $message }}</p>
            @enderror
          </div>
        
          <div class="sell-detail__group">
            <label for="price">販売価格</label>
            <div class="price-input">
              <span class="price-mark">￥</span>
              <input type="text" id="price" name="price" value="{{ old('price') }}" required>
            </div>
            @error('price')
                <p class="error">{{ $message }}</p>
            @enderror
          </div>
        </div>
        
        <button class= "sell__btn" type="submit">出品する</button>
     </form>

   </div>
@endsection
