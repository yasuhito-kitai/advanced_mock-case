@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review_confirm.css') }}">
@stop

@section('content')
<form action="/mypage/review/send" method="post">
    @csrf
    <input type="hidden" name="shop_id" value="{{$review_content['shop_id']}}">
    <input type="hidden" name="reservation_id" value="{{$review_content['reservation_id']}}">
    <input type="hidden" name="star" value="{{$review_content['star']}}">
    <input type="hidden" name="comment" value="{{$review_content['comment']}}">
    <table>
        <caption>「{{$review_content['shop_name']}}」</caption>
        <tr>
            <th>評価</th>
            <td>
                @if($review_content['star']==5)
                <p>5★★★★★</p>
                @elseif($review_content['star']==4)
                <p>4★★★★</p>
                @elseif($review_content['star']==3)
                <p>3★★★</p>
                @elseif($review_content['star']==2)
                <p>2★★</p>
                @else($review_content['star']==1)
                <p>1★</p>
                @endif
            </td>
        </tr>
        <tr>
            <th>コメント</th>
            <td>{{$review_content['comment']}}</td>
        </tr>
    </table>
    上記の内容で投稿してよろしいですか？

    <div class=" review-confirm__submit">
        <button type="submit" class="review-confirm__submit-button">投稿する</button>
    </div>
</form>
@stop