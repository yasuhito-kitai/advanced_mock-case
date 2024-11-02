@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/visit_status_change.css') }}">
@stop

@section('content')
<div>
    <p>この予約を＜来店済＞に変更してよろしいですか？</p>
</div>

<div>
    <a class="detail-block__back-button--button" href="{{ url()->previous() }}">＜</a>
    <table class="reservation-details">
        <tr class="reservation-item__row">
            <th class="reservation-item__header">予約者</th>
            <td class="reservation-item__data">{{$reservation_record->user->name}}</td>
        </tr>
        <tr class="reservation-item__row">
            <th class="reservation-item__header">来店日</th>
            <td class="reservation-item__data">{{$reservation_record->date}}</td>
        </tr>
        <tr class="reservation-item__row">
            <th class="reservation-item__header">時間</th>
            <td class="reservation-item__data">{{$reservation_record->time}}</td>
        </tr>
        <tr class="reservation-item__row">
            <th class="reservation-item__header">人数</th>
            <td class="reservation-item__data">{{$reservation_record->number}}</td>
        </tr>
    </table>

    <form class="" action="/visit-status/done" method="post">
        @csrf
        @method('PATCH')
        <input type="hidden" name="reservation_id" value="{{ $reservation_record->id }}">
        <input type="hidden" name="prevUrl" value="{{ $prevUrl }}">
        <button class="visit-status__button--submit" type="submit">はい</button>
    </form>
</div>
@stop