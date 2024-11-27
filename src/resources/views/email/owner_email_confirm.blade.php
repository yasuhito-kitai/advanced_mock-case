@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner_email_confirm.css') }}">
@stop

@section('content')
<div class="email__group__flex">
    <div class="email__group">
        <div class="email-section-title">
            <h2 class="section-title__text">この内容で送信してよろしいですか？</h2>
        </div>

        <div class="email-form__group">
            <form class="email-confirm" action="/owner-email/send" method="post">
                @csrf
                <input type="hidden" name="user_id" value="{{$receiver['user_id']}}">
                <input type="hidden" name="email" value="{{$receiver['email']}}">
                <h2 class="item__header">宛先</h2>
                <p class="item__content">{{$receiver['name']}} 様 （{{$receiver['email']}}）</p>

                <input type="hidden" name="subject" value="{{$receiver['subject']}}">
                <div>
                    <h2 class="item__header">件名</h2>
                    <p class="item__content">{{$receiver['subject']}}</p>
                </div>

                <input type="hidden" name="body" value="{{$receiver['body']}}">
                <div>
                    <h2 class="item__header">本文</h2>
                    <p class="item__content" style="white-space: pre-wrap;">{{$receiver['body']}}</p>
                </div>

                <div class="button__group">
                    <div>
                        <button class="back__btn" type="submit" name='back' value="back">修正する</button>
                    </div>

                    <div>
                        <input class="email-send__btn" type="submit" value="送信する">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop