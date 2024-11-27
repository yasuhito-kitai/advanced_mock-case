@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@stop

@section('content')
<div class="thanks-card">
    <div class="thanks-card__text">
        <p class="thanks-card__text--txt">ご予約ありがとうございます</p>
    </div>

    <div class="thanks-card__back-button">
        <a class="thanks-card__back-button--button" href="{{ url()->previous() }}">戻る</a>
    </div>
</div>
@stop