@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/purchase-address.css') }}" />
@endsection

@section('content')

    <div class="address-form__content">
      <div class="address-form__heading">
        <h2>住所の変更</h2>
      </div>
      <form action="{{ route('purchase.address.update', $item) }}" method="POST">
        @csrf
        
        <div class="address-group">
            <label for="post_code">郵便番号</label>
            <input type="post_code" id="post_code" name="post_code" value="{{ old('post_code', $user->post_code) }}" required>
            @error('post_code')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="address-group">
            <label for="address">住所</label>
            <input type="address" id="address" value="{{ old('address', $user->address) }}"  name="address" required>
            @error('address')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="address-group">
            <label for="building">建物名</label>
            <input type="building" id="building" name="building" value="{{ old('building', $user->building) }}" required>
        </div>
        
        <button class= "update__btn" type="submit">更新する</button>
     </form>

   </div>
@endsection