@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@stop

@section('content')
<div class="flex__item">
    @foreach($shop_all as $shop)
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