@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner_page.css') }}">
@stop

@section('content')
<div class="owner-page__shop-register">
    <!-- 初回登録時のみ表示（店舗登録） -->
    @unless($shop)
    <div class="shop-register-block">
        <h1>店舗情報登録</h1>
        <p class="shop-register__text">店舗情報を入力してください</p>

        <form class="shop-register__form" action="/shop/register/confirm" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{$user_id}}">
            <div class="shop-register__item-text">
                <input class="auth-form__input" type="text" name="name" placeholder="店舗名" value="{{ old('name') }}">
                <p class="error-message">
            </div>

            <div class="auth-form__item">

                <select class="shop-register__item-select" name="area_id">
                    <option hidden>エリア</option>
                    @foreach($areas as $area)
                    <option value="{{$area->id}}" @if($area->id===(int)old('area_id')) selected @endif>{{$area->name}}</option>
                    @endforeach
                </select>

            </div>
            <div class=" shop-register__item">
                <select class="shop-register__item-select" name="genre_id">
                    <option hidden>ジャンル</option>
                    @foreach($genres as $genre)
                    <option value="{{$genre->id}}" @if($genre->id===(int)old('genre_id')) selected @endif>{{$genre->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="shop-register__item-text">
                <textarea class="auth-form__input" name="overview" placeholder="概要">{{ old('overview') }}</textarea>
            </div>

            <div class="shop-register__item-image">
                <input type="file" class="auth-form__input" name="image" accept="image/png, image/jpeg, image/jpg, image/gif">
            </div>


            <input class="shop-register__btn" type="submit" value="確認画面へ">
        </form>
    </div>
</div>

@else
<div class="owner-page__reservation-list">
    <!-- 登録後の表示（店舗情報更新、予約状況確認） -->
    <div class="shop-header-block">
        <p>{{$shop->name}}</p>
        <form action="/myshop/detail/{{$shop->id}}" method=" get">
            <button type="submit">店舗詳細</button>
        </form>
    </div>


    <div class="reservation-list-block">

        <div class="display-date__items">
            <form action="/before_day" method="get">
                @csrf
                <input type="hidden" name="display_date" value="{{$display_date}}">
                <input class="before-day__button" type="submit" value="<">
            </form>

            <div class="display-date">{{$display_date}}</div>

            <form action="/next_day" method="get">
                @csrf
                <input type="hidden" name="display_date" value="{{$display_date}}">
                <input class="next-day__button" type="submit" value=">">
            </form>
        </div>

        <div class="calendar__items">
            <form class="calendar__form" action="/calendar" method="get">
                @csrf
                <input type="date" class="select-display-date" name=" select_date">
                <input class="search__button" type="submit" value="検索">
            </form>
        </div>

        <table class="date-list__table">
            <tr class="date-list__row">
                <th class="date-list__header">予約者</th>
                <th class="date-list__header">時間</th>
                <th class="date-list__header">人数</th>
            </tr>

            @foreach($item_records as $item_record)
            <tr class="date-list__row">
                <td class="date-list__data">{{$item_record->user->name}} 様</td>
                <td class="date-list__data">{{$item_record->time}}</td>
                <td class="date-list__data">{{$item_record->number}}</td>
            </tr>
            @endforeach
        </table>

    </div>
</div>
@endunless
@stop