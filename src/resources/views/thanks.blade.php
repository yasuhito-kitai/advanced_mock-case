@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@stop

@section('content')
<div class="thanks-card">
    <p class="thanks-card__text">ご予約ありがとうございます</p>
        <div class="thanks-card__back-button">
            <button  class="thanks-card__back-button btn"><a class="users-list" href="/login">ログインする</a></button>
        </div>
</div>
@stop