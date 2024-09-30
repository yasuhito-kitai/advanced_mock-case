@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register_shop_confirm.css') }}">
@stop

@section('content')
<div class="detail-block">

    <form class="shop-register-form" action="/shop/register/done" method="post">
        @csrf

        <div class="detail-block__header">
            <div class="detail-block__header__title">
                <input type="hidden" name="user_id" value="{{$shop_detail['user_id']}}">
                <input type="hidden" name="name" value="{{$shop_detail['name']}}">
                <h2 class="detail-block__header__title-text">{{$shop_detail['name']}}</h2>
            </div>
        </div>

        <div class="detail-block__content">
            <div class="detail-block__content__img">
                <input type="hidden" name="image" value="{{$image_name}}">
                @if($image_name=='/img/noimage.jpg')
                <img src=" {{$image_name}} ">
                @else
                <img src=" /storage/tmp/{{$image_name}} ">
                @endif
            </div>

            <div class="detail-block__content__tag">
                <input type="hidden" name="area_id" value="{{$shop_detail['area_id']}}">
                <input type="hidden" name="genre_id" value="{{$shop_detail['genre_id']}}">
                <p class="detail-block__content__tag-item">#{{$area_name}}</p>
                <p class="detail-block__content__tag-item">#{{$genre_name}}</p>
            </div>

            <div class="detail-content__overview">
                <input hidden name="overview" value="{{$shop_detail['overview']}}">
                <p class="detail-content__overview-text">{{$shop_detail['overview']}}</p>
            </div>
        </div>

        <button type="submit" name='back' value="back">修正する</button>
        <input class="shop-register__btn" type="submit" value="登録する">
        
    </form>
</div>
@stop