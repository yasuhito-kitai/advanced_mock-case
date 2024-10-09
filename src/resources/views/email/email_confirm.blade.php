@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/email_confirm.css') }}">
@stop

@section('content')
<form class="email-confirm" action="/email/send" method="post">
    @csrf
        <input type="hidden" name="user_id" value="{{$receiver['user_id']}}">
        <input type="hidden" name="email" value="{{$receiver['email']}}">
            <h2>宛先</h2>
            <div>{{$receiver['name']}} 様 （{{$receiver['email']}}）</div>

        <input type="hidden" name="subject" value="{{$receiver['subject']}}">
        <div>
            <h2>件名</h2>
            <p>{{$receiver['subject']}}</p>
        </div>

        <input type="hidden" name="body" value="{{$receiver['body']}}">
        <div>
            <h2>本文</h2>
            <p>{{$receiver['body']}}</p>
        </div>

    <button type="submit" name='back' value="back">修正する</button>
    <input class="email-send__btn" type="submit" value="送信する">
</form>
@stop