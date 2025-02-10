@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@stop

@section('content')

<!-- 店舗代表者以外 -->
@cannot('owner')
<div class="whole-container">
    <!-- 店舗詳細ブロック -->
    <div class="detail-block">
        <div class="detail-block__header">
            <div class="detail-block__back-button">
                @if (Auth::check())
                @if (preg_match("/reserve/", $prevUrl))
                <a class="detail-block__back-button--button" href="/mypage">＜</a>
                @elseif (preg_match("/mypage/", $currentUrl))
                <a class="detail-block__back-button--button" href="/mypage">＜</a>
                @elseif (preg_match("/review/", $prevUrl))
                <a class="detail-block__back-button--button" href="/">＜</a>
                @else
                <input class="detail-block__back-button--button" type="button" onclick="history.back()" value="＜"></input>
                @endif
                @else
                <input class="detail-block__back-button--button" type="button" onclick="history.back()" value="＜"></input>
                @endif
            </div>

            <div class="detail-block__header__title">
                <h2 class="detail-block__header__title-text">{{$shop_detail->name}}</h2>
            </div>
        </div>

        <div class="detail-block__content">
            <div class="detail-block__content__img">
                <img class="detail-block__content__img--img" src=" {{$shop_detail->image}}">
            </div>

            <div class="detail-block__content__tag">
                <p class="detail-block__content__tag-item">#{{$shop_detail->area->name}}</p>
                <p class="detail-block__content__tag-item">#{{$shop_detail->genre->name}}</p>
            </div>

            <div class="detail-content__overview">
                <p class="detail-content__overview-text">{{$shop_detail->overview}}</p>
            </div>
        </div>

        <div class="detail-content__review">
            <div class="review__header">全ての口コミ情報</div>
            @foreach($reviews as $review)
            <!-- 投稿ユーザーのみ編集と削除可 -->
            @if (Auth::id() === $review->reservation->user_id)
            <div class="review__edit-delete">
                <div class="review__edit">
                    <form class="edit-form" action="/review/edit" method="get">
                        <input type="hidden" name="id" value="{{$review->reservation_id}}">
                        <input class="review-edit__button" type="submit" value="口コミを編集">
                    </form>
                </div>

                <div class="review__delete">
                    <form class="delete-form" action="/review/delete" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" value="{{$review->reservation_id}}">
                        <input type="hidden" name="shop_id" value="{{$shop_detail->id}}">
                        <input class="review-delete__button" type="submit" value="口コミを削除" onclick="return confirm('口コミを削除しますか？')">
                    </form>
                </div>
            </div>
            @endif

            <!-- 管理者だけはすべての口コミを削除可 -->
            @can('admin')
            <div class="review__delete">
                <form class="delete-form" action="/review/delete" method="post">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id" value="{{$review->reservation_id}}">
                    <input type="hidden" name="shop_id" value="{{$shop_detail->id}}">
                    <input class="review-delete__button" type="submit" value="口コミを削除" onclick="return confirm('口コミを削除しますか？')">
                </form>
            </div>
            @endcan

            <div class="review__content">
                <div class="review--star__group">
                    @if($review->star==5)
                    <div class="review--star">★★★★★</div>
                    @elseif($review->star==4)
                    <div class="review--star">★★★★☆</div>
                    @elseif($review->star==3)
                    <div class="review--star">★★★☆☆</div>
                    @elseif($review->star==2)
                    <div class="review--star">★★☆☆☆</div>
                    @else
                    <div class="review--star">★☆☆☆☆</div>
                    @endif
                </div>

                <div class="review--comment" style="white-space: pre-wrap;">{{$review->comment}}</div>

                @if(isset($review->image))
                <div class="review--image"><img src="{{$review->image}}"></div>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- 予約ブロック -->
    <div class="reservation-block__container">
        <div class="reservation-block">
            <div class="reservation-block__title">
                <p2 class="reservation-block__title__title-text">予約</p2>
            </div>
            <!-- 予約フォーム -->
            <div class="reservation-block__content">
                <form class="reservation-block__content-form" action="/reserve" method="post">
                    @csrf
                    <!-- 店舗id -->
                    <input type="hidden" name="shop_id" value="{{$shop_detail->id}}">
                    <!-- 店舗名 -->
                    <input type="hidden" name="shop_name" value="{{$shop_detail->name}}">
                    <!-- 日付 -->
                    <input class="reservation-block__content-input--date" name="date" type="date" min="{{$today}}" value="{{ old('date') }}" class="reservation-block__content-form--input">
                    <p class="error-message">
                        @error('date')
                        {{ $message }}
                        @enderror
                    </p>
                    <!-- 時間 -->
                    <select class="reservation-block__content-select--time" name="time">
                        <option value="" hidden>時間</option>
                        @for ($h=11; $h<=23; $h++){ echo <option value="{{$h .':' . '00'}}" @if(old('time')==$h .':' . '00' ) selected @endif>{{$h .':' . '00'}}</option>,
                            <option value="{{$h .':' . '15'}}" @if(old('time')==$h .':' . '15' ) selected @endif>{{$h .':' . '15'}}</option>,
                            <option value="{{$h .':' . '30'}}" @if(old('time')==$h .':' . '30' ) selected @endif>{{$h .':' . '30'}}</option>,
                            <option value="{{$h .':' . '45'}}" @if(old('time')==$h .':' . '45' ) selected @endif>{{$h .':' . '45'}}</option>
                            }
                            @endfor
                    </select>
                    <p class="error-message">
                        @error('time')
                        {{ $message }}
                        @enderror
                    </p>
                    <!-- 人数 -->
                    <select class="reservation-block__content-select--number" name="number">
                        <option value="" hidden>人数</option>
                        @for ($i=1; $i<=50; $i++) {
                            echo<option value="{{$i}}人" @if(old('number')==$i.'人' ) selected @endif>{{$i}}人</option>
                            }
                            @endfor
                    </select>
                    <p class="error-message">
                        @error('number')
                        {{ $message }}
                        @enderror
                    </p>

                    <!-- 予約ボタン -->
                    <div class="reservation-block__content-button">
                        <button type="submit" class="reservation-block__content-button--btn">予約する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan


<!-- 店舗代表者のみ -->
@can('owner')
<div class="whole-container">
    <!-- 店舗詳細ブロック -->
    <div class="detail-block">
        <div class="detail-block__header">
            <div class="detail-block__back-button">
                @if (preg_match("/owner-page/", $prevUrl))
                <a class="detail-block__back-button--button" href="/owner-page">＜</a>
                @elseif (preg_match("/myshop/", $currentUrl))
                <a class="detail-block__back-button--button" href="/owner-page">＜</a>
                @else
                <a class="detail-block__back-button--button" href="/">＜</a>
                @endif
            </div>

            <div class="detail-block__header__title">
                <h2 class="detail-block__header__title-text">{{$shop_detail->name}}</h2>
            </div>
            @if($shop_detail->user_id == $user_id)
            <form class="update-form" action="/shop/edit/{{$shop_detail->id}}" method="get">
                <div class="shop-content-update">
                    <input type="hidden" name="id" value="{{ $shop_detail->id }}">
                    <input class="shop-content-update__button" type="submit" value="店舗情報修正"></input>
                </div>
            </form>
            @endif
        </div>

        <div class="detail-block__content">
            <div class="detail-block__content__img">
                <img class="detail-block__content__img--img" src="{{$shop_detail->image}}">
            </div>

            <div class="detail-block__content__tag">
                <p class="detail-block__content__tag-item">#{{$shop_detail->area->name}}</p>
                <p class="detail-block__content__tag-item">#{{$shop_detail->genre->name}}</p>
            </div>

            <div class="detail-content__overview">
                <p class="detail-content__overview-text">{{$shop_detail->overview}}</p>
            </div>
        </div>

        <div class="detail-content__review">
            <div class="review__header">全ての口コミ情報</div>
            @foreach($reviews as $review)
            <div class="review__content">
                <div class="review--star__group">
                    @if($review->star==5)
                    <div class="review--star">5★★★★★</div>
                    @elseif($review->star==4)
                    <div class="review--star">4★★★★☆</div>
                    @elseif($review->star==3)
                    <div class="review--star">3★★★☆☆</div>
                    @elseif($review->star==2)
                    <div class="review--star">2★★☆☆☆</div>
                    @else
                    <div class="review--star">1★☆☆☆☆</div>
                    @endif
                </div>

                <div class="review--comment">{{$review->comment}}</div>
                <div class="review--image"><img src="{{$review->image}}"></div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- 予約ブロック -->
    <div class="reservation-block__container">
        <div class="reservation-block">
            <div class="reservation-block__title">
                <p2 class="reservation-block__title__title-text">予約</p2>
            </div>
            <!-- 予約フォーム -->
            <div class="reservation-block__content">
                <form class="reservation-block__content-form" action="/reserve" method="post">
                    @csrf
                    <!-- 店舗id -->
                    <input type="hidden" name="shop_id" value="{{$shop_detail->id}}">
                    <!-- 店舗名 -->
                    <input type="hidden" name="shop_name" value="{{$shop_detail->name}}">
                    <!-- 日付 -->
                    <input class="reservation-block__content-input--date" name="date" type="date" min="{{$today}}" value="{{ old('date') }}" class="reservation-block__content-form--input">
                    <p class="error-message">
                        @error('date')
                        {{ $message }}
                        @enderror
                    </p>
                    <!-- 時間 -->
                    <select class="reservation-block__content-select--time" name="time">
                        <option value="" hidden>時間</option>
                        @for ($h=11; $h<=23; $h++){ echo <option value="{{$h .':' . '00'}}" @if(old('time')==$h .':' . '00' ) selected @endif>{{$h .':' . '00'}}</option>,
                            <option value="{{$h .':' . '15'}}" @if(old('time')==$h .':' . '15' ) selected @endif>{{$h .':' . '15'}}</option>,
                            <option value="{{$h .':' . '30'}}" @if(old('time')==$h .':' . '30' ) selected @endif>{{$h .':' . '30'}}</option>,
                            <option value="{{$h .':' . '45'}}" @if(old('time')==$h .':' . '45' ) selected @endif>{{$h .':' . '45'}}</option>
                            }
                            @endfor
                    </select>
                    <p class="error-message">
                        @error('time')
                        {{ $message }}
                        @enderror
                    </p>
                    <!-- 人数 -->
                    <select class="reservation-block__content-select--number" name="number">
                        <option value="" hidden>人数</option>
                        @for ($i=1; $i<=50; $i++) {
                            echo<option value="{{$i}}人" @if(old('number')==$i.'人' ) selected @endif>{{$i}}人</option>
                            }
                            @endfor
                    </select>
                    <p class="error-message">
                        @error('number')
                        {{ $message }}
                        @enderror
                    </p>

                    <!-- 予約ボタン -->
                    <div class="reservation-block__content-button">
                        <button type="submit" class="reservation-block__content-button--btn">予約する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan
@stop