@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@stop

@section('content')
@can('general')
<div class="thanks-card">
    <p class="thanks-card__text">会員登録ありがとうございます</p>
    <div class="thanks-card__button">
        <a class="thanks-card__button--btn" href="/login">ログインする</a>
    </div>
</div>
@endcan

@can('owner')<!-- 店舗代表がメール認証クリック後、初めてログインをした際の表示 -->
<div class="thanks-card">
    <p class="thanks-card__text">認証に成功しました</br>
        メニューのOwner-pageから店舗情報を登録してください</p>
    <div class="thanks-card__button">
        <a class="thanks-card__button--btn" href="/login">ホーム画面へ</a>
    </div>
</div>
@endcan

@can('admin')<!-- 管理者が店舗代表者を登録した際の表示 -->
<div class="thanks-card">
    <p class="thanks-card__text">店舗代表者のユーザー登録が完了しました</br>
        店舗代表者に認証のためのメールが送られました</p>
    <div class="thanks-card__button">
        <a class="thanks-card__button--btn" href="/">ホーム画面へ</a>
    </div>
</div>
@endcan
@stop