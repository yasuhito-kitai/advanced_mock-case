<?php

use Illuminate\Support\Facades\Auth;

?>

@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@stop

@section('content')
<p class="user-name"><?php $user = Auth::user(); ?>{{ $user->name }}さん</p>
@if(session('message'))
<div class="todo__alert--success">
    <p>{{ session('message') }}</p>
</div>
@endif
<div class="whole-container">

    <!-- 予約状況ブロック -->
    <div class="reservation-status-block">
        <div class="reservation-status-block__title">
            <h1 class="reservation-status__title-text">予約状況</h1>
        </div>

        @foreach($reservation_details as $index=>$reservation_detail)
        <div class="reservation-status__unit">

            <div class="reservation-status__unit__header">
                <div class="watch-icon">
                    <img class="watch-icon__img" src="{{asset('img/時計のアイコン.png')}}">
                </div>

                <div class="reservation-number">
                    <p class="reservation-number__text">予約 {{$index+1}}</p>
                </div>

                <form class="change-form" action="/reserve/change" method="get">
                    <div class="reservation-change">
                        <input type="hidden" name="id" value="{{ $reservation_detail->id }}">
                        <input class="reservation-change__button" type="submit" value="予約内容の変更"></input>
                    </div>
                </form>

                <form class="cancel-form" action="/reserve/cancel" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="cancel-icon">
                        <input type="hidden" name="id" value="{{ $reservation_detail->id }}">
                        <input class="cancel-icon__img" type="image" src="{{asset('img/キャンセルのアイコン.png')}}" alt="予約キャンセル" onclick="return confirm('予約{{$index+1}}を取り消しますか？')">
                    </div>
                </form>
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