@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner_page.css') }}">
@stop

@section('content')
<div class="owner-page__flex">
    <!-- 初回登録時のみ表示（店舗登録） -->
    @unless($shop)
    <div class="shop-register-block">
        <div class="shop-register-block__title">
            <h1>店舗情報登録</h1>
        </div>

        <div class="shop-register-block__form">
            <form class="shop-register__form" action="/shop/register/confirm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="shop-register__header">店舗名</div>
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <div class="shop-register__item">
                    <input class="shop-register__item__input" type="text" name="name" placeholder="店舗名を入力してください" value="{{ old('name') }}">
                </div>

                <div class="error-message">
                    @error('name')
                    <p class="error-message__text">{{ $message }}</p>
                    @enderror
                </div>


                <div class="shop-register__item">
                    <select class="shop-register__item--select" name="area_id">
                        <option hidden>エリア</option>
                        @foreach($areas as $area)
                        <option value="{{$area->id}}" @if($area->id===(int)old('area_id')) selected @endif>{{$area->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="error-message">
                    @error('area_id')
                    <p class="error-message__text">{{ $message }}</p>
                    @enderror
                </div>


                <div class="shop-register__item">
                    <select class="shop-register__item--select" name="genre_id">
                        <option hidden>ジャンル</option>
                        @foreach($genres as $genre)
                        <option value="{{$genre->id}}" @if($genre->id===(int)old('genre_id')) selected @endif>{{$genre->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="error-message">
                    @error('genre_id')
                    <p class="error-message__text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="shop-register__header">概要</div>
                <div class="shop-register__item">
                    <textarea class="shop-register__item--textarea" name="overview" placeholder="概要を入力してください">{{ old('overview') }}</textarea>
                </div>

                <div class="error-message">
                    @error('overview')
                    <p class="error-message__text">{{ $message }}</p>
                    @enderror
                </div>

                <div class="shop-register__item-image">
                    <input type="file" class="shop-register__item--image" name="image" accept="image/png, image/jpeg, image/jpg, image/gif">
                </div>

                <div class="shop-register__button">
                    <input class=" shop-register__button--btn" type="submit" value="確認画面へ">
                </div>
            </form>
        </div>
    </div>


    @else
    <div class="owner-page__reservation-list">
        <!-- 登録後の表示（店舗情報更新、予約状況確認） -->
        <div class="shop-header-block">
            <p class="shop-header-block__shop-name">{{$shop->name}}＜予約一覧＞</p>
            <div class="shop-header-block__shop-detail-button">
                <form action="/detail/{{$shop->id}}" method=" get">
                    <button class="detail__button" type="submit">店舗詳細</button>
                </form>
            </div>
        </div>

        <div class="reservation-list-block">
            <div class="display-date__items">
                <form action="/owner-page" method="get">
                    @csrf
                    <button class="today__button" type="submit">今日</button>
                </form>

                <form action="/before_day" method="get">
                    @csrf
                    <input type="hidden" name="display_date" value="{{$display_date}}">
                    <input class="before-day__button" type="submit" value="<">
                </form>

                <div class="display-date">
                    <p display-date__text>{{$display_date}}</p>
                </div>

                <form action="/next_day" method="get">
                    @csrf
                    <input type="hidden" name="display_date" value="{{$display_date}}">
                    <input class="next-day__button" type="submit" value=">">
                </form>


                <div class="calendar__items">
                    <form class="calendar__form" action="/calendar" method="get" onchange="submit(this.form)">
                        @csrf
                        <input type="date" class="select-display-date" name="select_date">
                    </form>
                </div>
            </div>

            <div class="list-group">
                <table class="date-list__table">
                    <tr class="date-list__row">
                        <th class="date-list__header">
                            <p class="header-text">状態</p>
                        </th>
                        <th class="date-list__header">
                            <p class="header-text">予約者</p>
                        </th>
                        <th class="date-list__header">
                            <p class="header-text">時間</p>
                        </th>
                        <th class="date-list__header">
                            <p class="header-text">人数</p>
                        </th>
                        <th class="date-list__header"></th>
                        <th class="date-list__header"></th>

                    </tr>

                    @foreach($item_records as $item_record)
                    <tr class="date-list__row">
                        <td class="date-list__data">
                            @if($item_record->visit_status=='0')
                            @if("{{$display_date}}"<"{{$today}}")
                                <p class="data-text">ｷｬﾝｾﾙ</p>
                                @else
                                <p class="data-text">予約中</p>
                                @endif
                                @else
                                <p class="data-text">来店済</p>
                                @endif
                        </td>
                        <td class="date-list__data">
                            <p class="data-text">{{$item_record->user->name}} 様</p>
                        </td>
                        <td class="date-list__data">
                            <p class="data-text">{{$item_record->time}}</p>
                        </td>
                        <td class="date-list__data">
                            <p class="data-text">{{$item_record->number}}</p>
                        </td>
                        <form class="email-index__form" action="/owner-email" method="get">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $item_record->user_id }}">
                            <td class="transition-email__button"><button class="transition-email__button--submit" type="submit">メール送付</button>

                                <button class="transition-email__button--submit" type="submit">
                                    <div class="email-icon">
                                        <img class="email-icon__img" src="img/メールのアイコン.png">
                                    </div>
                                </button>
                            </td>
                        </form>


                        @if($item_record->visit_status=='0')
                        <form class="visit-status-form" action="/visit-status" method="get">
                            @csrf
                            <input type="hidden" name="reservation_id" value="{{ $item_record->id }}">
                            <td class="visit-status__button"><button class="visit-status__button--submit" type="submit">来店済にする</button></td>
                        </form>
                        @endif
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        @endunless
    </div>
</div>
@stop