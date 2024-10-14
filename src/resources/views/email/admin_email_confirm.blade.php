@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_email_confirm.css') }}">
@stop

@section('content')
<form class="email-confirm" action="/admin-email/send" method="post">
    @csrf
    <h2>宛先</h2>
    <p class="address">利用者全員</p>

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