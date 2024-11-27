@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify_email.css') }}">
@stop

@section('content')
<div class="verify-card">
    <div class="main-message">
        <p class="main-message__text">ご登録いただいたメールアドレスへ認証リンクを送信しましたので、<br>
            クリックして認証を完了させてください。<br>
            もし、認証メールが届かない場合は再送させていただきます。</p>
    </div>

    <div class=" resubmit-button">
        <form action="/email/verification-notification" method="post">
            @csrf
            <input class="resubmit-button__btn" type="submit" value="認証メールを再送信する">
        </form>
    </div>

    <!-- フラッシュメッセージ -->
    @if (session('message'))
    <div class="flash-message">
        <p class="flash-message__text">{{ session('message') }}</p>
    </div>
    @endif

    <div class="return-home">
        <form action="/" method="get">
            @csrf
            <input class="return-home__btn" type="submit" value="ホーム画面に戻る">
        </form>
    </div>
    @stop