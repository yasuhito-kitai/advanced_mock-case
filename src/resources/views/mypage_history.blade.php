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
    @if($user->role=="general")
    <p class="user-status">＜{{$member_status}}＞</p>
    @elseif($user->role=="owner")
    <p class="user-status">＜店舗代表者＞</p>
    @else
    <p class="user-status">＜管理者＞</p>
    @endif
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
<div class="whole-container__wrapper">
    <div class="whole-container">
        <!-- 予約履歴ブロック -->
        <div class="history-block">
            <div class="history-block">
                <div class="history-block__title">
                    <div class="item-title-status--tab">
                        <a class="item-title-status" href="/mypage">予約状況</a>
                    </div>
                    <div class="item-title-history--tab">
                        <a class="item-title-history" href="/mypage/history">予約履歴</a>
                    </div>
                </div>
                <div class="history__container">
                    @if($reservation_details=="[]")
                    <p class="no-reservation">履歴がありません</p>
                    @endif
                    @foreach($reservation_details as $index=>$reservation_detail)
                    <div class="history__unit">
                        <div class="history__unit__header">
                            <div class="watch-icon">
                                <img class="watch-icon__img" src="{{asset('img/時間経過のアイコン.png')}}">
                            </div>

                            <div class="history-number">
                                <p class="history-number__text">履歴 {{$index+1}}</p>
                            </div>

                            @if (!in_array($reservation_detail->id, $reviewed_reservations))
                            <form class="review-form" action="/mypage/review/make" method="get">
                                <div class="make_review">
                                    <input type="hidden" name="id" value="{{ $reservation_detail->id }}">
                                    <input class="make_review__button" type="submit" value="レビューを書く"></input>
                                </div>
                            </form>
                            @else
                            <div class="reviewed">レビュー投稿済</div>
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
                        </table>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- お気に入り店舗ブロック -->
        <div class=" favorite-shops-block">
            <div class="favorite-shops__title">
                <h1 class="favorite-shops__title__title-text">お気に入り店舗</h1>
                <h1 class="favorite-shops__title__title-text__blank"></h1>
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
                        <div class="detail-favorite__flex">
                            <div class="shop-card__content__detail">
                                <form class="shop-card__content__detail-form" action="/mypage/detail/{{$favorite->shop->id}}" method="get">
                                    @csrf
                                    <input class="shop-card__content__detail-btn" type="submit" value="詳しくみる">
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
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop