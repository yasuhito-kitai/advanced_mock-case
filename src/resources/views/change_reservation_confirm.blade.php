@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/change_reservation_confirm.css') }}">
@stop

@section('content')

<div class="whole-container">
    <!--変更前 -->
    <div class="reservation-status__unit">
        <div class="unit-title">
            <p class="unit-title__text">現在の予約内容</p>
        </div>

        <div class="unit__item">
            <table class="reservation-details">
                <tr class="before-item__row">
                    <th class="reservation-item__header">Shop</th>
                    <td class="reservation-item__data">{{$before_details['name']}}</td>
                </tr>
                <tr class="before-item__row">
                    <th class="reservation-item__header">Date</th>
                    <td class="reservation-item__data">{{$before_details['before_date']}}</td>
                </tr>
                <tr class="before-item__row">
                    <th class="reservation-item__header">Time</th>
                    <td class="reservation-item__data">{{$before_details['before_time']}}</td>
                </tr>
                <tr class="before-item__row">
                    <th class="reservation-item__header">Number</th>
                    <td class="reservation-item__data">{{$before_details['before_number']}}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="arrow-icon">
        <img class="arrow-icon__img--right" src="{{asset('img/右矢印アイコン.png')}}">
        <img class="arrow-icon__img--bottom" src="{{asset('img/下矢印アイコン.png')}}">
    </div>


    <!--変更後 -->
    <div class="reservation-status__unit">
        <form class="change-form" action="/reserve/change/update" method="post">
            @csrf
            @method('PATCH')
            <div class="unit-title">
                <p class="unit-title__text">変更後の予約内容</p>
            </div>

            <div class="unit__item">
                <table class="reservation-details">
                    <tr class="after-item__row">
                        <th class="reservation-item__header">Shop</th>
                        <input type="hidden" name="id" value="{{ $after_details['id'] }}">
                        <td class="reservation-item__data">{{$after_details['name']}}</td>
                    </tr>
                    <tr class="after-item__row">
                        <th class="reservation-item__header">Date</th>
                        <input type="hidden" name="date" value="{{$after_details['after_date']}}">
                        <td class="reservation-item__data">{{$after_details['after_date']}}</td>
                    </tr>
                    <tr class="after-item__row">
                        <th class="reservation-item__header">Time</th>
                        <input type="hidden" name="time" value="{{$after_details['after_time']}}">
                        <td class="reservation-item__data">{{$after_details['after_time']}}</td>
                    </tr>
                    <tr class="after-item__row">
                        <th class="reservation-item__header">Number</th>
                        <input type="hidden" name="number" value="{{$after_details['after_number']}}">
                        <td class="reservation-item__data">{{$after_details['after_number']}}</td>
                    </tr>
                </table>
            </div>

            <div class="button-flex">
                <div class="back">
                    <a class="back__button" href="{{ url()->previous() }}">戻る</a>
                </div>

                <div class="change-submit">
                    <button class="change-submit__button" type="submit" class="">この内容に変更する</button>
                </div>
        </form>
    </div>
</div>
@stop