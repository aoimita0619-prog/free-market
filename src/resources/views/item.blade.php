@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@section('content')
<div class="content">
    <div class="column">
      <div class="item-img__area">
        <img src="{{ $item->img ? asset('storage/' . $item->img) : '' }}" class="item__img">
      </div>
    </div>
    <div class="column">
        <h2 class="item__name">{{ $item->name }}</h2>
        <p class="item__brand">{{ $item->brand }}</p>
        <p class="item__price">￥{{ $item->price }}（税込）</p>

       <div class="count__area">
        <div class="faivorit">
         @if(auth()->check())
         @if(auth()->user()->favoriteItems->contains($item->id))
         <form action="{{ route('favorite.destroy', $item) }}" method="POST">
            @csrf
            @method('DELETE')
         <button type="submit" class="favorite-btn">
          <img src="{{ asset('img/heart_pink.png') }}" alt=""  class="click__img">
         </button>
         </form>
         @else
        <form action="{{ route('favorite.store', $item) }}" method="POST">
            @csrf
            <button type="submit" class="favorite-btn">
              <img src="{{ asset('img/heart.png') }}" alt=""  class="click__img">
            </button>
        </form>
        @endif
        @else
         <button type="button" class="favorite-btn" disabled>
          <img src="{{ asset('img/heart.png') }}" alt="" class="click__img">
         </button>
        @endif
        <span class="favorite__count" >{{ $item->favoriteUsers()->count() }}</span>
        </div>
        <div class="comment">
          <img src="{{ asset('img/comment.png') }}" alt="" class="click__img">
          <span class="favorite__count" >{{ $item->comments()->count() }}</span>
        </div>
        </div>
        @if(auth()->check() && auth()->id() !== $item->user_id && !$item->is_sold)
          <a href="{{ route('purchase.create', $item) }}">
            <button class= "purchase__btn" type="submit">購入手続きへ</button>
          </a>
        @elseif(auth()->check() && auth()->id() == $item->user_id && !$item->is_sold)
        @elseif($item->is_sold)
          <button class= "sold__btn" type="button" disabled>売り切れ</button>
        @else
          <a href="{{ route('register') }}">
            <button class= "purchase__btn" type="submit">会員登録して購入</button>
          </a>
        @endif

        <h3>商品説明</h3>
        <p>{{ $item->detail }}</p>

        <h3>商品の情報</h3>
        <div class="info__table">
          <table class="info-table__inner">
            <tr class="info-table__row">
              <th class="info-table__header">カテゴリー</th>
              <td class="info-table__text">
                <div class="category__list">
                  @foreach ($item->categories as $category)
                  <span class="category__item">{{ $category->content }}</span>
                  @endforeach
                </div>
              </td>
            </tr>
            <tr class="info-table__row">
              <th class="info-table__header">商品の状態</th>
              <td class="info-table__text">
                <p class="condition__item">{{ $item->condition->condition }}</p>
              </td>
            </tr>
          </table>
       </div>
       <h2 class="item__comment">コメント({{$item->comments()->count()}})</h2>
       @foreach($item->comments as $comment)
       <div class="comment__list">
          <div class="user__area">
            <img src="{{ $comment->user->img ? asset('storage/' . $comment->user->img) : '' }}" class="user__img">
            <strong class="user__name">{{ $comment->user->name }}</strong>
         </div>
          <p class="user__comment">{{ $comment->comment }}</p>
        </div>
        @endforeach
        <h3>商品へのコメント</h3>
       <form action="{{ route('comment.store', $item) }}" method="POST">
        @csrf
       <textarea name="comment">{{ old('comment') }}</textarea>
       @error('comment')
                <p class="error">{{ $message }}</p>
       @enderror
       @if(auth()->check())
        <button class= "comment__btn" type="submit">コメントを送信する</button>
       </form>
       @else
        <a href="{{ route('register') }}">
         <button class= "comment__btn" type="submit">会員登録してコメントを送信</button>
        </a>
       @endif
    </div>
</div>

@endsection