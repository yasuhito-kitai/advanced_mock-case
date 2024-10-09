@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit_shop.css') }}">
@stop

@section('content')
<div class="whole-container">
    <!-- 店舗詳細ブロック -->
    <div class="detail-block">
        <form class="shop-update-form" action="/shop/edit/{{$shop_detail->id}}/confirm" method="post" enctype="multipart/form-data">
            @csrf
            <div class="detail-block__header">
                <div class="detail-block__back-button">
                    @if (preg_match("/detail/", $prevUrl))
                        <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
                    @elseif (preg_match("/myshop/", $prevUrl))
                        <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
                    @else
                        <a class="detail-block__back-button--button" href="/myshop/detail/{{$shop_detail->id}}">＜</a>
                    @endif
                </div>

                <div class="request-message">
                    <p>変更内容を入力してください</p>
                </div>
                <!-- 店舗名 -->
                <div class="detail-block__header__title">
                    <p>店舗名</p>

                    <!-- 変更後 -->
                    <input type="hidden" name="shop_id" value="{{$shop_detail->id}}">
                    <input type="text" name="name" value="{{$shop_detail->name}}" class="detail-block__header__title-text">
                </div>
            </div>

            <div class="detail-block__content">
                <!-- 画像 -->
                <div class="detail-block__content__img">
                    <img src="{{$shop_detail->image}}">
                    <input type="file" class="edit-form__input" name="image" accept="image/png, image/jpeg, image/jpg, image/gif">
                </div>

                <!-- エリア -->
                <div class="detail-block__content__tag">
                    <p>エリア</p>

                    <!-- 変更後 -->
                    <select class="detail-block__content__tag-item" name="area_id">
                        <option value="{{$shop_detail->area_id}}">{{$shop_detail->area->name}}</option>
                        @foreach($areas as $area)
                        <option value="{{$area->id}}" {{request()->area_id=="$area->id" ? "selected" : "";}}>{{$area->name}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- ジャンル -->
                <div class="detail-block__content__tag">
                    <p>ジャンル</p>

                    <!-- 変更後 -->
                    <select class="detail-block__content__tag-item" name="genre_id">
                        <option value="{{$shop_detail->genre_id}}">{{$shop_detail->genre->name}}</option>
                        @foreach($genres as $genre)
                        <option value="{{$genre->id}}" {{request()->genre_id=="$genre->id" ? "selected" : "";}}>{{$genre->name}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 概要 -->
                <div class="detail-content__overview">
                    <p>概要</p>

                    <!-- 変更後 -->
                    <textarea name="overview" class="detail-content__overview-text">{{$shop_detail->overview}}</textarea>
                </div>
            </div>

            <div class="detail-block__submit">
                <button type="submit" class="reservation-block__submit-button">確認画面へ</button>
            </div>
        </form>
    </div>
</div>
@stop