@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review_edit.css') }}">
@stop

@section('content')

    <div class="whole-container">
        @if (preg_match("/confirm/", $prevUrl))
        <a class="detail-block__back-button--button" href="/detail/{{$reservation_record['shop_id']}}">＜</a>
        @else
        <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
        @endif

        <div class="review__group">
            <div class="review-section-title">
                <h2 class="section-title__text">「{{$reservation_record['shop_name']}}」のレビュー</h2>
            </div>

            <div class="review-form__group">
                <form action="/review/edit/confirm" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="reservation_id" value="{{$reservation_record['id']}}">
                    <input type="hidden" name="shop_name" value="{{$reservation_record['shop_name']}}">
                    <input type="hidden" name="shop_id" value="{{$reservation_record['shop_id']}}">
                    <h2 class="item__header">評価</h2>

                    <div class="form-rating">
                        <input class="form-rating__input" name="star" type="hidden" value="">

                        <input class="form-rating__input" id="star5" name="star" type="radio" value="5" @if(old('star')==5 ) checked @endif>
                        <label class="form-rating__label" for="star5">★</label>

                        <input class="form-rating__input" id="star4" name="star" type="radio" value="4" @if(old('star')==4) checked @endif>
                        <label class="form-rating__label" for="star4">★</label>

                        <input class="form-rating__input" id="star3" name="star" type="radio" value="3" @if(old('star')==3 ) checked @endif>
                        <label class="form-rating__label" for="star3">★</label>

                        <input class="form-rating__input" id="star2" name="star" type="radio" value="2" @if(old('star')==2 ) checked @endif>
                        <label class="form-rating__label" for="star2">★</label>

                        <input class="form-rating__input" id="star1" name="star" type="radio" value="1" @if(old('star')==1 ) checked @endif>
                        <label class="form-rating__label" for="star1">★</label>
                    </div>

                    <h2 class="item__header">コメント</h2>
                    <div class="form-group">
                        @if(old('comment'))
                        <textarea class="item__content--comment" name="comment" onkeyup="document.getElementById('count').value=this.value.length">{{ old('comment') }}</textarea>
                        @else
                        <textarea class="item__content--comment" name="comment" onkeyup="document.getElementById('count').value=this.value.length">{{$current_review->comment}}</textarea>
                        @endif
                    
                    <div class="count-box"><input class="count" type="text" id="count" readonly>/400（最高文字数）</div>
</div>
                    <div class="error-message">
                        @error('comment')
                        <p class="error-message__text">{{ $message }}</p>
                        @enderror
                    </div>

                    <h2 class="item__header">画像</h2>
                    <div class="current-image__box">
                        <div class="current-image--title">現在の画像</div>
                        @if(isset($current_review->image))
                        <div class="current-image--image">
                            <img src="{{$current_review->image}}">
                        </div>
                        @elseif(old('image'))
                        <div class="current-image--image">
                            <img src="{{old('image')}}">
                        </div>
                        @else
                        <div class="current-image--no-image">登録されている画像はありません</div>
                        @endif
                    </div>
                    <div class="new-image__box">
                        <div class="new-image--title">新しい画像を選ぶ</div>
                        <div class="file-button">
                            <input type="file" class="file-button--input" name="image">
                        </div>
                    </div>
                    <div class="error-message">
                        @error('image')
                        <p class="error-message__text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="confirm-button">
                        <button type="submit" class="confirm-button--btn">確認画面へ</button>
                    </div>
                </form>
            </div>
        </div>
    </di>

@stop