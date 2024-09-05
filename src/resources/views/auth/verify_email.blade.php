@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify_email.css') }}">
@stop

@section('content')
<div class="main-message">ご登録ありがとうございます！<br>
    ご入力いただいたメールアドレスへ認証リンクを送信しましたので、クリックして認証を完了させてください。<br>
    もし、認証メールが届かない場合は再送させていただきます。
</div>

<div class="resubmit-button">
    <form action="/email/verification-notification" method="post">
        @csrf
        <input class="resubmit-button__btn" type="submit" value="認証メールを再送信する">
    </form>
</div>

<!-- フラッシュメッセージ -->
@if (session('message'))
<div class="flash-message">
    {{ session('message') }}
</div>
@endif

<div class="return-login">
    <form action="/logout" method="post">
        @csrf
        <input class="return-login__btn" type="submit" value="ログイン画面へ戻る">
    </form>
</div>
@stop