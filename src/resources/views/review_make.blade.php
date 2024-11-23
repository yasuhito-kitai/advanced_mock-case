@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review_make.css') }}">
@stop

@section('content')
<div class="whole-container__wrapper">
    <div class="whole-container">
        @if (preg_match("/confirm/", $prevUrl))
        <a class="detail-block__back-button--button" href="/mypage/history">＜</a>
        @else
        <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
        @endif

        <div class="review__group">
            <div class="review-section-title">
                <h2 class="section-title__text">「{{$reservation_record['shop_name']}}」のレビュー</h2>
            </div>

            <div class="review-form__group">
                <form action="/mypage/review/confirm" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{$reservation_record['shop_id']}}">
                    <input type="hidden" name="reservation_id" value="{{$reservation_record['id']}}">
                    <input type="hidden" name="shop_name" value="{{$reservation_record['shop_name']}}">
                    <h2 class="item__header">評価</h2>
                    <div class="form-group">
                        <select class="item__content--star" name="star">
                            <option value="" hidden>選択してください</option>

                            <option value="5" @if(old('star')==5 ) selected @endif>5★★★★★</option>,
                            <option value="4" @if(old('star')==4 ) selected @endif>4★★★★</option>,
                            <option value="3" @if(old('star')==3 ) selected @endif>3★★★</option>,
                            <option value="2" @if(old('star')==2 ) selected @endif>2★★</option>,
                            <option value="1" @if(old('star')==1 ) selected @endif>1★</option>
                        </select>
                    </div>

                    <div class="error-message">
                        @error('star')
                        <p class="error-message__text">{{ $message }}</p>
                        @enderror
                    </div>


                    <h2 class="item__header">コメント</h2>
                    <div class="form-group">
                        <textarea class="item__content--comment" name="comment">{{ old('comment') }}</textarea>
                    </div>

                    <div class="error-message">
                        @error('comment')
                        <p class="error-message__text">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="confirm-button">
                        <button type="submit" class="confirm-button--btn">確認画面へ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop