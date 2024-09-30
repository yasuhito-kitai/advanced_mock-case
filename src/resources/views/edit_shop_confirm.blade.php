@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/edit_shop.css') }}">
@stop

@section('content')
<div class="back">
    <a class="back__button" href="{{ url()->previous() }}">戻る</a>
</div>

<div class="whole-container">
    <!--変更後 -->
    <form class="change-form" action="/shop/edit/{{$after_details['shop_id']}}/update" method="post">
        @csrf
        @method('PATCH')
        <p>変更後の店舗情報</p>
        <div class="detail-block">
            <div class="detail-block__header">
                <div class="detail-block__header__title">
                    <input type="hidden" name="name" value="{{$after_details['name']}}">
                    <h2 class="detail-block__header__title-text">{{$after_details['name']}}</h2>
                </div>
            </div>

            <div class="detail-block__content">
                <div class="detail-block__content__img">
                    <input type="hidden" name="image_name" value="{{$image_name}}">
                    <img src="{{$image_path}}">
                </div>

                <div class="detail-block__content__tag">
                    <input type="hidden" name="area_id" value="{{$after_details['area_id']}}">
                    <input type="hidden" name="genre_id" value="{{$after_details['genre_id']}}">
                    <p class="detail-block__content__tag-item">#{{$area_name}}</p>
                    <p class="detail-block__content__tag-item">#{{$genre_name}}</p>
                </div>

                <div class="detail-content__overview">
                    <input type="hidden" name="overview" value="{{$after_details['overview']}}">
                    <p class="detail-content__overview-text">{{$after_details['overview']}}</p>
                </div>
            </div>
        </div>

        <div class="update-submit">
            <button class="update-submit__button" type="submit" class="">店舗情報を更新する</button>
        </div>
</div>
</form>
</div>
@stop