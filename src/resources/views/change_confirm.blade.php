@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/change_confirm.css') }}">
@stop

@section('content')
<div class="thanks-card__back-button">
    <a class="thanks-card__back-button--button" href="{{ url()->previous() }}">戻る</a>
</div>
<div class="whole-container">
    <!--変更前 -->
    <div class="before-card">
        <p>現在の予約内容</p>
        <div class="before-card__item">
            <table class="before-details">
                <tr class="before-item__row">
                    <th class="before-item__header">Shop</th>
                    <td class="before-item__data">{{$before_details['name']}}</td>
                </tr>
                <tr class="before-item__row">
                    <th class="before-item__header">Date</th>
                    <td class="before-item__data">{{$before_details['before_date']}}</td>
                </tr>
                <tr class="before-item__row">
                    <th class="before-item__header">Time</th>
                    <td class="before-item__data">{{$before_details['before_time']}}</td>
                </tr>
                <tr class="before-item__row">
                    <th class="before-item__header">Number</th>
                    <td class="before-item__data">{{$before_details['before_number']}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="arrow">

        <p>></p>

    </div>



    <!--変更後 -->
    <form class="change-form" action="/update" method="post">
        @csrf
        @method('PATCH')
        <div class="after-card">
            <p>変更後の予約内容</p>
            <div class="after-card__item">
                <table class="after-details">
                    <tr class="after-item__row">
                        <th class="after-item__header">Shop</th>
                        <input type="hidden" name="id" value="{{ $after_details['id'] }}">
                        <td class="after-item__data">{{$after_details['name']}}</td>
                    </tr>
                    <tr class="after-item__row">
                        <th class="after-item__header">Date</th>
                        <input type="hidden" name="date" value="{{$after_details['after_date']}}">
                        <td class="after-item__data">{{$after_details['after_date']}}</td>
                    </tr>
                    <tr class="after-item__row">
                        <th class="after-item__header">Time</th>
                        <input type="hidden" name="time" value="{{$after_details['after_time']}}">
                        <td class="after-item__data">{{$after_details['after_time']}}</td>
                    </tr>
                    <tr class="after-item__row">
                        <th class="after-item__header">Number</th>
                        <input type="hidden" name="number" value="{{$after_details['after_number']}}">
                        <td class="after-item__data">{{$after_details['after_number']}}</td>
                    </tr>
                </table>
            </div>

            <div class="thanks-card__back-button">
                <button type="submit" class="">予約を変更する</button>
            </div>
        </div>
    </form>

</div>
@stop