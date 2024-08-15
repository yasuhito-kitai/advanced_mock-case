@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@stop

@section('content')
<div class="thanks-card">
    <p class="thanks-card__text">ご予約ありがとうございます</p>
    <form class="thanks__back-button-form" action="/back" method="post">
        <div class="thanks-card__back-button">
            <button type="submit" class="thanks-card__back-button btn">戻る</button>
        </div>
</div>
@stop