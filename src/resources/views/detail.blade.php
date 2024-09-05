@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@stop

@section('content')
<div class="whole-container">
    <!-- 店舗詳細ブロック -->
    <div class="detail-block">
        <div class="detail-block__header">
            <div class="detail-block__back-button">
                @if (Auth::check())
                @if (preg_match("/reserve/", $prevUrl))
                <a class="detail-block__back-button--button" href="/mypage">＜</a>
                @else
                <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
                @endif
                @else
                <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
                @endif
            </div>

            <div class="detail-block__header__title">
                <h2 class="detail-block__header__title-text">{{$shop_detail->name}}</h2>
            </div>
        </div>

        <div class="detail-block__content">
            <div class="detail-block__content__img">
                <img src="{{$shop_detail->image}}" alt="shop image" />
            </div>

            <div class="detail-block__content__tag">
                <p class="detail-block__content__tag-item">#{{$shop_detail->area->name}}</p>
                <p class="detail-block__content__tag-item">#{{$shop_detail->genre->name}}</p>
            </div>

            <div class="detail-content__overview">
                <p class="detail-content__overview-text">{{$shop_detail->overview}}</p>
            </div>
        </div>
    </div>

    <!-- 予約ブロック -->
    <div class="reservation-block">
        <div class="reservation-block__title">
            <p2 class="reservation-block__title__title-text">予約</p2>
        </div>
        <!-- 予約フォーム -->
        <div class="reservation-block__content">
            <form class="reservation-block__content-form" action="/reserve" method="post">
                @csrf
                <!-- 店舗id -->
                <input type="hidden" name="shop_id" value="{{$shop_detail->id}}">
                <!-- 店舗名 -->
                <input type="hidden" name="shop_name" value="{{$shop_detail->name}}">
                <!-- 日付 -->
                <input class="reservation-block__content-input--date" name="date" type="date" min="{{$today}}">
                <!-- 時間 -->
                <select class="reservation-block__content-select--time" name="time">
                    <option hidden>時間</option>
                    @for ($h=11; $h<=23; $h++){ echo<option value="{{$h .':' . '00'}}">{{$h .':' . '00'}}</option>,
                        <option value="{{$h .':' . '15'}}">{{$h .':' . '15'}}</option>,
                        <option value="{{$h .':' . '30'}}">{{$h .':' . '30'}}</option>,
                        <option value="{{$h .':' . '45'}}">{{$h .':' . '45'}}</option>
                        }
                        @endfor
                </select>
                <!-- 人数 -->
                <select class="reservation-block__content-select--number" name="number">
                    <option hidden>人数</option>
                    @for ($i=1; $i<=50; $i++) {
                        echo<option value="{{$i}}人">{{$i}}人</option>
                        }
                        @endfor
                </select>
                <!-- 予約ボタン -->
                <div class="reservation-block__content-button">
                    <button type="submit" class="reservation-block__content-button btn">予約する</button>
                </div>

            </form>
        </div>
    </div>
</div>
@stop