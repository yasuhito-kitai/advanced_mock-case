@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner_email_index.css') }}">
@stop

@section('content')
@if (preg_match("/confirm/", $prevUrl))
<a class="detail-block__back-button--button" href="/owner-page">＜</a>
@else
<a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
@endif
<h2 class="section-title">予約者へのお知らせメール</h2>

<div class="email__group">
    <form class="email__form" action="/owner-email/confirm" method="post">
        @csrf



        <div class="form-group">
            <h2>宛先</h2>
            <input type="hidden" name="user_id" value="{{$receiver['user_id']}}">
            <input type="hidden" name="name" value="{{$receiver['name']}}">
            <input type="hidden" name="email" value="{{$receiver['email']}}">
            <p class="address">{{$receiver['name']}} 様 ({{$receiver['email']}})</p>
        </div>

        <h2>件名</h2>
        <div class="form-group">
            <input class="input-subject" type="text" name="subject" value="{{old('subject')}}">
        </div>
        @error('subject')
        {{ $message }}
        @enderror

        <h2>本文</h2>
        <div class="form-group">
            <textarea class="input-body" name="body">{{ old('body') }}</textarea>
        </div>
        @error('body')
        {{ $message }}
        @enderror

        <input class="confirm-btn" type="submit" value="確認画面へ">
    </form>
</div>
@stop