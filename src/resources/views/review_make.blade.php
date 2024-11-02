@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/make_review.css') }}">
@stop

@section('content')
<form action="/mypage/review/confirm" method="post">
    @csrf
    <input type="hidden" name="shop_id" value="{{$reservation_record->shop_id}}">
    <input type="hidden" name="reservation_id" value="{{$reservation_record->id}}">
    <input type="hidden" name="shop_name" value="{{$reservation_record->shop->name}}">
    <table>
        <caption>「{{$reservation_record->shop->name}}」</caption>
        <tr>
            <th>評価</th>
            <td>
                <select class=" reservation-block__content-select--time" name="star">
                    <option value="" hidden>選択してください</option>

                    <option value="5" @if(old('star')==5 ) selected @endif>5★★★★★</option>,
                    <option value="4" @if(old('star')==4 ) selected @endif>4★★★★</option>,
                    <option value="3" @if(old('star')==3 ) selected @endif>3★★★</option>,
                    <option value="2" @if(old('star')==2 ) selected @endif>2★★</option>,
                    <option value="1" @if(old('star')==1 ) selected @endif>1★</option>
                </select>
                <p class="error-message">
                    @error('star')
                    {{ $message }}
                    @enderror
                </p>
            </td>
        </tr>
        <tr>
            <th>コメント</th>
            <td><textarea class="comment" name="comment">{{ old('comment') }}</textarea>
                <p class="error-message">
                    @error('comment')
                    {{ $message }}
                    @enderror
                </p>
            </td>
        </tr>

    </table>

    <div class="review-confirm__submit">
        <button type="submit" class="review-confirm__submit-button">確認画面へ</button>
    </div>
</form>
@stop