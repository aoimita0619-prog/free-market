@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('content')
    <div class="mypage__profile">
      <img src="{{ $user->img ? asset('storage/' . $user->img) : '' }}" class="user__img">
      <span>{{ $user->name }}</span>
      <div class="profile-btn">
        <a class="profile-update" href="{{ route('profile', $user->id) }}">プロフィールを編集</a>
      </div>
    </div>
    
    <div class="mypage__content">
        <div class="mypage-content__heading">
            <a href="{{ route('mypage', ['tab' => 'sell']) }}" class="{{ $tab == 'sell' ? 'active' : '' }}">
              出品した商品
            </a>

            <a href="{{ route('mypage', ['tab' => 'buy']) }}" class="{{ $tab === 'buy' ? 'active' : '' }}">
              購入した商品
            </a>
        </div>
        <hr>
        
        
        <div class="mypage-content__item">
           @foreach ($items as $item)
           <form  class="mypage-form__item">
            <div class="mypage__item">
              <a href="{{ route('item.show', $item->id) }}">
              <img src="{{ $item->img ? asset('storage/' . $item->img) : '' }}" class="item__img">
              <input type="hidden" name="name" value="{{ $item->name }}" readonly />
              <p class="item__item">{{ $item->name }}</p>
              </a>
            </div>
            </form>
           @endforeach
        </div>
        

    </div>
@endsection
