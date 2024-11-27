@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner_email.css') }}">
@stop

@section('content')
<div class="whole-container__wrapper">
    <div class="whole-container">
        @if (preg_match("/confirm/", $prevUrl))
        <a class="detail-block__back-button--button" href="/owner-page">＜</a>
        @else
        <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
        @endif


        <div class="email__group">
            <div class="email-section-title">
                <h2 class="section-title__text">予約者へのお知らせメール</h2>
            </div>

            <div class="email-form__group">
                <form class="email__form" action="/owner-email/confirm" method="post">
                    @csrf
                    <h2 class="item__header">宛先</h2>
                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{{$receiver['user_id']}}">
                        <input type="hidden" name="name" value="{{$receiver['name']}}">
                        <input type="hidden" name="email" value="{{$receiver['email']}}">
                        <p class="item__content">{{$receiver['name']}} 様 ({{$receiver['email']}})</p>
                    </div>

                    <h2 class="item__header">件名</h2>
                    <div class="form-group">
                        <input class="item__content" type="text" name="subject" value="{{old('subject')}}">
                    </div>

                    <div class="error-message">
                        @error('subject')
                        <p class="error-message__text">{{ $message }}</p>
                        @enderror
                    </div>

                    <h2 class="item__header">本文</h2>
                    <div class="form-group">
                        <textarea class="item__content" name="body">{{ old('body') }}</textarea>
                    </div>

                    <div class="error-message">
                        @error('body')
                        <p class="error-message__text">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="confirm-button">
                        <input class="confirm-button--btn" type="submit" value="確認画面へ">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    @stop