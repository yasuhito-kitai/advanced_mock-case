@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@stop

@section('header')

<div class="search-form__flex">
    <form class="search-form" action="/search_shop" method="get">
        <div class="search-form__item">
            <div class="sort__box">
                <div class="sort__title">並び替え：</div>
                <select class="search-form__item-sort--select" name="sort" onchange="submit(this.form)">
                    <option value="random" {{ request()->sort == "" ? "selected" : "" }}>ランダム</option>
                    <option value="desc" {{ request()->sort == "desc" ? "selected" : "" }}>評価が高い順</option>
                    <option value="asc" {{ request()->sort == "asc" ? "selected" : "" }}>評価が低い順</option>
                </select>
            </div>

            <select class="search-form__item-area--select" name="area_id" onchange="submit(this.form)">
                <option value="">All area</option>
                @foreach($areas as $area)
                <option value="{{$area->id}}" {{request()->area_id=="$area->id" ? "selected" : "";}}>{{$area->name}}</option>
                @endforeach
            </select>

            <select class="search-form__item-genre--select" name="genre_id" onchange="submit(this.form)">
                <option value="">All genre</option>
                @foreach($genres as $genre)
                <option value="{{$genre->id}}" {{request()->genre_id=="$genre->id" ? "selected" : "";}}>{{$genre->name}}</option>
                @endforeach
            </select>

            <div class="search-form__item-keyword">
                <input class="search-form__item-keyword--input" type="text" name="keyword" placeholder="Search ..." value="{{request()->keyword}}">
            </div>
        </div>
    </form>
</div>
@stop


@section('content')
@if (count($shops) === 0)
<div class="notFound-message">
    <p>条件に合う店舗が見つかりませんでした。条件を変えて検索してください。</p>
</div>
@endif
<div class="shop-card__flex-wrapper">
    <div class="shop-card__flex">
        @foreach($shops as $shop)
        <div class="shop-card">
            <div class="shop-card__img">
                <img src="{{$shop->image}}" alt="shop image">
            </div>

            <div class="shop-card__content">
                <div class="shop-card__header">
                    <h2 class="shop-card__content-ttl">{{$shop->name}}</h2>
                    <div class="shop-card__content-star">★</div>
                    @if($shop->avg_star == "-1.00")
                    <div class="shop-card__content-rating">評価なし</div>
                    @else
                    <div class="shop-card__content-rating">{{$shop->avg_star}}</div>
                    @endif
                </div>
                <div class="shop-card__content-tag">
                    <p class="shop-card__content-tag-item">#{{$shop->area->name}}</p>
                    <p class="shop-card__content-tag-item">#{{$shop->genre->name}}</p>
                </div>
                <div class="detail-favorite__flex">
                    <div class="shop-card__content__detail">
                        <form class="shop-card__content__detail-form" action="/detail/{{$shop->id}}" method="get">
                            @csrf
                            <input class="shop-card__content__detail-btn" type="submit" value="詳しくみる">
                        </form>
                    </div>

                    <div class="shop-card__content__favorite">
                        <form class="shop-card__content__favorite-form" action="/favorite/{id}" method="post">
                            @csrf
                            @if (Auth::check())
                            @if ($favorites->where("user_id","=",$user_id)->where("shop_id","=",$shop["id"])->first())
                            <button class="heart red" type="submit" name="shop_id" value="{{$shop->id}}"></button>
                            @else
                            <button class="heart gray" type="submit" name="shop_id" value="{{$shop->id}}"></button>
                            @endif
                            @else
                            <button class="heart gray" type="submit" name="shop_id" value="{{$shop->id}}"></button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        <div class="shop-card__blank">
        </div>
    </div>
</div>
@stop