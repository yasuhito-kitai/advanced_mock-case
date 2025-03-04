@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review_make.css') }}">
<link rel=”stylesheet” href=”https://use.fontawesome.com/releases/v6.4.2/css/all.css”>
@stop

@section('content')
<div class="whole-container">
    <!-- 左 -->
    <div class="shop-card__area">
        <div class="message">今回のご利用はいかがでしたか？</div>
        <div class="shop-card">
            <div class="shop-card__img">
                <img src="{{$shop->image}}" alt="shop image">
            </div>
            <div class="shop-card__content">
                <div class="shop-card__header">
                    <h2 class="shop-card__content-ttl">{{$shop->name}}</h2>
                </div>
                <div class="shop-card__content-tag">
                    <p class="shop-card__content-tag-item">#{{$shop->area->name}}</p>
                    <p class="shop-card__content-tag-item">#{{$shop->genre->name}}</p>
                </div>
                <div class="detail-favorite__flex">
                    <div class="shop-card__content__detail">
                        <form class="shop-card__content__detail-form" action="/detail/{{$shop->id}}" method="get">
                            @csrf
                            <input class="shop-card__content__detail-btn" type="submit" value="詳しくみる">
                        </form>
                    </div>

                    <div class="shop-card__content__favorite">
                        <form class="shop-card__content__favorite-form" action="/favorite/{id}" method="post">
                            @csrf
                            @if (Auth::check())
                            @if ($favorites->where("user_id","=",$user_id)->where("shop_id","=",$shop["id"])->first())
                            <button class="heart red" type="submit" name="shop_id" value="{{$shop->id}}"></button>
                            @else
                            <button class="heart gray" type="submit" name="shop_id" value="{{$shop->id}}"></button>
                            @endif
                            @else
                            <button class="heart gray" type="submit" name="shop_id" value="{{$shop->id}}"></button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 右 -->
    <div class="review__area">
        <form action="/mypage/review/confirm" method="post" enctype="multipart/form-data" id="review__submit">
            @csrf
            <input type="hidden" name="reservation_id" value="{{$reservation_record['id']}}">
            <input type="hidden" name="shop_name" value="{{$reservation_record['shop_name']}}">
            <input type="hidden" name="shop_id" value="{{$reservation_record['shop_id']}}">
            <h2 class="item__header">体験を評価してください</h2>

            <div class="form-rating">
                <input class="form-rating__input" name="star" type="hidden" value="">

                <input class="form-rating__input" id="star5" name="star" type="radio" value="5" @if(old('star')==5 ) checked @endif>
                <label class="form-rating__label" for="star5">★</label>

                <input class="form-rating__input" id="star4" name="star" type="radio" value="4" @if(old('star')==4) checked @endif>
                <label class="form-rating__label" for="star4">★</label>

                <input class="form-rating__input" id="star3" name="star" type="radio" value="3" @if(old('star')==3 ) checked @endif>
                <label class="form-rating__label" for="star3">★</label>

                <input class="form-rating__input" id="star2" name="star" type="radio" value="2" @if(old('star')==2 ) checked @endif>
                <label class="form-rating__label" for="star2">★</label>

                <input class="form-rating__input" id="star1" name="star" type="radio" value="1" @if(old('star')==1 ) checked @endif>
                <label class="form-rating__label" for="star1">★</label>
            </div>

            <div class="error-message">
                @error('star')
                <p class="error-message__text">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="item__header">口コミを投稿</h2>
            <div class="form-group">
                <textarea class="item__content--comment" name="comment" onkeyup="document.getElementById('count').value=this.value.length">{{ old('comment') }}</textarea>
            </div>
            <div class="count-box"><input class="count" type="text" id="count" readonly>/400（最高文字数）</div>

            <div class="error-message">
                @error('comment')
                <p class="error-message__text">{{ $message }}</p>
                @enderror
            </div>

            <h2 class="item__header">画像の追加</h2>
            <div class="file-button">
                <input type="file" class="file-button--input" name="image">
            </div>

            <div class="error-message">
                @error('image')
                <p class="error-message__text">{{ $message }}</p>
                @enderror
            </div>
        </form>
    </div>
</div>

<div class="confirm-button">
    <button type="submit" class="confirm-button--btn" form="review__submit">確認画面へ</button>
</div>
@stop