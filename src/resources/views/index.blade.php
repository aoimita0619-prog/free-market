@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
    <div class="top__content">
        <div class="top-content__heading">
            <a href="{{ route('top') }}" class="{{ $tab !== 'mylist' ? 'active' : '' }}">
              おすすめ
            </a>

            <a href="{{ route('top', ['tab' => 'mylist']) }}" class="{{ $tab === 'mylist' ? 'active' : '' }}">
              マイリスト
            </a>
        </div>
        <hr>
        
        
        <div class="top-content__item">
           @foreach ($items as $item)
           <form  class="top-form__item">
            <div class="top__item">
              <a href="{{ route('item.show', $item->id) }}">
              <div class="item-card__img">
                <img src="{{ $item->img ? asset('storage/' . $item->img) : '' }}" class="item__img">
                @if($item->is_sold)
                  <span class="sold-label">SOLD</span>
                @endif
              </div>
              <input type="hidden" name="name" value="{{ $item->name }}" readonly />
              <p class="item__item">{{ $item->name }}</p>
              </a>
            </div>
            </form>
           @endforeach
        </div>
        

    </div>
@endsection
