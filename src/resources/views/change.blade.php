<?php

use Illuminate\Support\Facades\Auth;

?>

@extends('layouts.app')

@section('css')
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
                @if($reservation_detail->id ==request('id'))
                
                    <div class="thanks-card__back-button">
                        <a class="thanks-card__back-button--button" href="/mypage">戻る</a>
                    </div>
                
                @else
                <form class="change-form" action="/reserve/change" method="get">
                    <div class="reservation-change">
                        <input type="hidden" name="id" value="{{ $reservation_detail->id }}">
                        <input class="reservation-change__button" type="submit" value="予約内容の変更"></input>
                    </div>
                </form>
                @endif

                @if($reservation_detail->id ==request('id'))
                @else
                <form class="cancel-form" action="/reserve/cancel" method="post">
                    @method('DELETE')
                    @csrf
                    <div class="cancel-icon">
                        <input type="hidden" name="id" value="{{ $reservation_detail->id }}">
                        <input class="cancel-icon__img" type="image" src="{{asset('img/キャンセルのアイコン.png')}}" alt="予約キャンセル" onclick="return confirm('予約{{$index+1}}を取り消しますか？')">
                    </div>
                </form>
                @endif
            </div>

            @if($reservation_detail->id ==request('id'))
            <div class="request-message">
                <p>変更内容を入力してください</p>
            </div>

            <form class="reservation-block__content-form" action="/reserve/change/confirm" method="post">
                @csrf
                <div class="reservation-block__content">
                    <!-- 店舗名 -->
                    <input type="hidden" name="id" value="{{ $reservation_detail->id }}">
                    <input type="hidden" name="name" value="{{ $reservation_detail->shop->name }}">
                    <table class="reservation-details">
                        <tr class="reservation-item__row">
                            <th class="reservation-item__header">Shop</th>
                            <td class="reservation-item__data">{{$reservation_detail->shop->name}}</td>
                        </tr>
                        <!-- 日付 -->
                        <tr class="reservation-item__row">
                            <th class="reservation-item__header">Date</th>
                            <td class="reservation-item__data">
                                <!-- 変更前 -->
                                <input type="hidden" name="before_date" value="{{ $reservation_detail->date }}">
                                <!-- 変更後 -->
                                <input class="reservation-block__content-input--date" name="after_date" type="date" min="{{$today}}" value="{{$reservation_detail->date}}">
                            </td>
                        </tr>
                        <!-- 時間 -->
                        <tr class="reservation-item__row">
                            <th class="reservation-item__header">Time</th>
                            <td class="reservation-item__data">
                                <!-- 変更前 -->
                                <input type="hidden" name="before_time" value="{{ $reservation_detail->time }}">
                                <!-- 変更後 -->
                                <select class="reservation-block__content-select--time" name="after_time">
                                    <option value="{{$reservation_detail->time}}">{{$reservation_detail->time}}</option>
                                    @for ($h=11; $h<=23; $h++){ echo<option value="{{$h .':' . '00'}}">{{$h .':' . '00'}}</option>,
                                        <option value="{{$h .':' . '15'}}">{{$h .':' . '15'}}</option>,
                                        <option value="{{$h .':' . '30'}}">{{$h .':' . '30'}}</option>,
                                        <option value="{{$h .':' . '45'}}">{{$h .':' . '45'}}</option>
                                        }
                                        @endfor
                                </select>
                            </td>
                        </tr>
                        <!-- 人数 -->
                        <tr class="reservation-item__row">
                            <th class="reservation-item__header">Number</th>
                            <td class="reservation-item__data">
                                <!-- 変更前 -->
                                <input type="hidden" name="before_number" value="{{ $reservation_detail->number }}">
                                <!-- 変更後 -->
                                <select class="reservation-block__content-select--number" name="after_number">
                                    <option value="{{$reservation_detail->number}}">{{$reservation_detail->number}}</option>
                                    @for ($i=1; $i<=50; $i++) {
                                        echo<option value="{{$i}}人">{{$i}}人</option>
                                        }
                                        @endfor
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- 予約ボタン -->
                <div class="reservation-block__content-button">
                    <button type="submit" class="reservation-block__content-button btn">確認画面へ</button>
                </div>
            </form>
            @else
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
            @endif
        </div>

        @endforeach
    </div>

    <!-- お気に入り店舗ブロック -->
    <div class=" favorite-shops-block">
        <div class="favorite-shops__title">
            <h1 class="favorite-shops__title__title-text">お気に入り店舗</h1>
        </div>

        <div class="flex__item">
            @foreach($favorites as $favorite)
            <div class="card">
                <div class="card__img">
                    <img src="{{$favorite->shop->image}}" alt="shop image">
                </div>

                <div class="card__content">
                    <h2 class="card__content-ttl">{{$favorite->shop->name}}</h2>
                    <div class="card__content-tag">
                        <p class="card__content-tag-item">#{{$favorite->shop->area->name}}</p>
                        <p class="card__content-tag-item">#{{$favorite->shop->genre->name}}</p>
                    </div>

                    <div class="card__content__detail">
                        <form class="card__content__detail-form" action="/detail/{{$favorite->shop->id}}" method="get">
                            @csrf
                            <input class="card__content__detail-btn" type="submit" value="詳しくみる">
                        </form>
                    </div>

                    <div class="card__content__favorite">
                        <form class="card__content__favorite-form" action="/favorite/{id}" method="post">
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