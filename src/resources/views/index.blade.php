@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@stop

@section('header')
<div class="search-form__flex">
    <form class="search-form" action="/search_shop" method="get">

        <div class="search-form__item">
            <select class="search-form__item-select" name="area_id" onchange="submit(this.form)">
                <option value="">All area</option>
                @foreach($areas as $area)
                <option value="{{$area->id}}" {{request()->area_id=="$area->id" ? "selected" : "";}}>{{$area->name}}</option>
                @endforeach
            </select>

            <select class="search-form__item-select" name="genre_id" onchange="submit(this.form)">
                <option value="">All genre</option>
                @foreach($genres as $genre)
                <option value="{{$genre->id}}" {{request()->genre_id=="$genre->id" ? "selected" : "";}}>{{$genre->name}}</option>
                @endforeach
            </select>

            <input class="search-form__item--input" type="text" name="keyword" placeholder="Search..." value="{{request()->keyword}}">
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
<div class="flex__item">
    @foreach($shops as $shop)
    <div class="card">
        <div class="card__img">
            <img src="{{$shop->image}}" alt="shop image">
        </div>

        <div class="card__content">
            <h2 class="card__content-ttl">{{$shop->name}}</h2>
            <div class="card__content-tag">
                <p class="card__content-tag-item">#{{$shop->area->name}}</p>
                <p class="card__content-tag-item">#{{$shop->genre->name}}</p>
            </div>

            <div class="card__content__detail">
                <form class="card__content__detail-form" action="/detail/{{$shop->id}}" method="get">
                    @csrf
                    <input class="card__content__detail-btn" type="submit" value="詳しくみる">
                </form>
            </div>

            <div class="card__content__favorite">
                <form class="card__content__favorite-form" action="/favorite/{id}" method="post">
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
    @endforeach
</div>
@stop