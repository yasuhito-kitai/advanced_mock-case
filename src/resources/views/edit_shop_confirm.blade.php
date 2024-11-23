@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit_shop_confirm.css') }}">
@stop

@section('content')


<div class="whole-container__wrapper">
    <div class="whole-container">
        <!--変更後 -->
        <div class="detail-block">
            <form class="change-form" action="/shop/edit/{{$after_details['shop_id']}}/update" method="post">
                @csrf
                @method('PATCH')
                <div class="detail-block__header">
                    <div class="detail-block__back-button">
                        <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
                    </div>
                    <div class="header-message">
                        <p class="header-message--text">変更後の店舗情報</p>
                    </div>
                </div>

                <div class="detail-block__header__title">
                    <input type="hidden" name="name" value="{{$after_details['name']}}">
                    <h2 class="detail-block__header__title-text">{{$after_details['name']}}</h2>
                </div>


                <div class="detail-block__content">
                    <div class="detail-block__content__img">
                        <input type="hidden" name="image_name" value="{{$image_name}}">
                        <img src="{{$image_path}}">
                    </div>
                    <div class="select__flex">
                        <div class="detail-block__content__tag-item">
                            <input type="hidden" name="area_id" value="{{$after_details['area_id']}}">
                            <p class="detail-block__content__tag-item">#{{$area_name}}</p>
                        </div>
                        <div class="detail-block__content__tag-item">
                            <input type="hidden" name="genre_id" value="{{$after_details['genre_id']}}">

                            <p class="detail-block__content__tag-item">#{{$genre_name}}</p>
                        </div>
                    </div>
                    <div class="detail-content__overview">
                        <input type="hidden" name="overview" value="{{$after_details['overview']}}">
                        <p class="detail-content__overview-text">{{$after_details['overview']}}</p>
                    </div>



                    <div class="update-submit">
                        <button class="update-submit__button" type="submit">店舗情報を更新する</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop