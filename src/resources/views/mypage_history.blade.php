<?php

use Illuminate\Support\Facades\Auth;

?>

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage_history.css') }}">
@stop

@section('content')
<div class="name-area">
    <p class="user-name"><?php $user = Auth::user(); ?>{{ $user->name }}さん</p>
    <p class="user-status">＜{{$member_status}}＞</p>
</div>

@if($member_status=='一般会員')
<div class="induction-premium">
    <a href="/checkout">プレミアム会員になる</a>
</div>
@endif

@if(session('message'))
<div class="todo__alert--success">
    <p>{{ session('message') }}</p>
</div>
@endif
<div class="whole-container">

    <!-- 予約履歴ブロック -->
    <div class="history-block">

        <div class="history-block__title">
            <h1 class="item-title"><a href="/mypage">予約状況</a></h1>
            <h1 class="item-title"><a href="/mypage/history">予約履歴</a></h1>
        </div>

        @foreach($reservation_details as $index=>$reservation_detail)
        <div class="history__unit">

            <div class="history__unit__header">
                <div class="watch-icon">
                    <img class="watch-icon__img" src="{{asset('img/時間経過のアイコン.png')}}">
                </div>

                <div class="reservation-number">
                    <p class="reservation-number__text">履歴 {{$index+1}}</p>
                </div>
                @if($reservation_detail->visit_status=="1")
                <form class="review-form" action="/mypage/review/make" method="get">
                    <div class="make_review">
                        <input type="hidden" name="id" value="{{ $reservation_detail->id }}">
                        <input class="make_review__button" type="submit" value="レビューを書く"></input>
                    </div>
                </form>
                @endif
            </div>

            <table class="reservation-details">
                <tr class="reservation-item__row">
                    <th class="reservation-item__header">Shop</th>
                    <td class="reservation-item__data">{{$reservation_detail->shop->name}}</td>
                </tr>
                <tr class="reservation-item__row">
                    <th class="reservation-item__header">Date</th>
                    <td class="reservation-item__data">{{$reservation_detail->date}}</td>
                </tr>
                <tr class="reservation-item__row">
                    <th class="reservation-item__header">Time</th>
                    <td class="reservation-item__data">{{$reservation_detail->time}}</td>
                </tr>
                <tr class="reservation-item__row">
                    <th class="reservation-item__header">Number</th>
                    <td class="reservation-item__data">{{$reservation_detail->number}}</td>
                </tr>
                <tr class="reservation-item__row">
                    <th class="reservation-item__header">Status</th>
                    @if($reservation_detail->visit_status=="1")
                    <td class="reservation-item__data">来店済</td>
                    @else
                    <td class="reservation-item__data">キャンセル済</td>
                    @endif
                </tr>
            </table>
        </div>
        @endforeach
    </div>

    <!-- お気に入り店舗ブロック -->
    <div class=" favorite-shops-block">
        <div class="favorite-shops__title">
            <h1 class="favorite-shops__title__title-text">お気に入り店舗</h1>
        </div>

        <div class="shop-card__flex">
            @foreach($favorites as $favorite)
            <div class="shop-card">
                <div class="shop-card__img">
                    <img src="{{$favorite->shop->image}}" alt="shop image">
                </div>

                <div class="shop-card__content">
                    <h2 class="shop-card__content-ttl">{{$favorite->shop->name}}</h2>
                    <div class="shop-card__content-tag">
                        <p class="shop-card__content-tag-item">#{{$favorite->shop->area->name}}</p>
                        <p class="shop-card__content-tag-item">#{{$favorite->shop->genre->name}}</p>
                    </div>

                    <div class="shop-card__content__detail">
                        <form class="shop-card__content__detail-form" action="/mypage/detail/{{$favorite->shop->id}}" method="get">
                            @csrf
                            <input class="card__content__detail-btn" type="submit" value="詳しくみる">
                        </form>
                    </div>

                    <div class="shop-card__content__favorite">
                        <form class="shop-card__content__favorite-form" action="/favorite/{id}" method="post">
                            @csrf
                            <button class="heart red" type="submit" name="shop_id" value="{{$favorite->shop->id}}"></button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop