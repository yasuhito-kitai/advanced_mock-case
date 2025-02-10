@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review_confirm.css') }}">
<link rel="stylesheet" href="{{ asset('css/review_edit_confirm.css') }}">
@stop

@section('content')
<div class="review-confirm__group__flex">
    <div class="review-confirm__group">
        <div class="review-confirm-section-title">
            <h2 class="section-title__text">「{{$review_content['shop_name']}}」レビュー内容確認</h2>
        </div>

        <div class="review-confirm-form__group">
            <form action="/review/update" method="post">
                @csrf
                @method('PATCH')
                <input type="hidden" name="reservation_id" value="{{$review_content['reservation_id']}}">
                <input type="hidden" name="shop_id" value="{{$review_content['shop_id']}}">
                <input type="hidden" name="star" value="{{$review_content['star']}}">
                <input type="hidden" name="comment" value="{{$review_content['comment']}}">
                <input type="hidden" name="image" value="{{$image_path}}">
                <input type="hidden" name="image_name" value="{{$image_name}}">
                <h2 class="item__header">評価</h2>
                <div class="form-group">
                    @if($review_content['star']==5)
                    <p class="item__content">5★★★★★</p>
                    @elseif($review_content['star']==4)
                    <p class="item__content">4★★★★</p>
                    @elseif($review_content['star']==3)
                    <p class="item__content">3★★★</p>
                    @elseif($review_content['star']==2)
                    <p class="item__content">2★★</p>
                    @else($review_content['star']==1)
                    <p class="item__content">1★</p>
                    @endif
                </div>

                <h2 class="item__header">コメント</h2>
                <div class="form-group">
                    <p class="item__content" style="white-space: pre-wrap;">{{$review_content['comment']}}</p>
                </div>

                <h2 class="item__header">画像</h2>
                
                <div class="image">
                    <img src="{{$tmp_image_path}}">

                </div>

                <div class="button__group">
                    <div>
                        <button class="back__btn" type="submit" name='back' value="back">修正する</button>
                    </div>

                    <div>
                        <input class="review-send__btn" type="submit" value="送信する">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop