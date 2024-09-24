@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner_page.css') }}">
@stop

@section('content')
<div class="owner-page-container">
    <div class="shop-register-block">
        <p class="shop-register__text">店舗情報を入力してください</p>

        <form class="shop-register__form" action="/shop/register" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" value="{{$user_id}}">
            <div class="shop-register__item-text">
                <input class="auth-form__input" type="text" name="name" placeholder="店舗名" value="{{ old('name') }}">
                <p class="error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="auth-form__item">
                <select class="shop-register__item-select" name="area_id">
                    <option hidden>所在地</option>
                    @foreach($areas as $area)
                    <option value="{{$area->id}}" {{request()->area_id=="$area->id" ? "selected" : "";}}>{{$area->name}}</option>
                    @endforeach
                </select>

            </div>
            <div class="shop-register__item">
                <select class="shop-register__item-select" name="genre_id">
                    <option hidden>ジャンル</option>
                    @foreach($genres as $genre)
                    <option value="{{$genre->id}}" {{request()->genre_id=="$genre->id" ? "selected" : "";}}>{{$genre->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="shop-register__item-text">
                <textarea class="auth-form__input" name="overview" placeholder="概要">{{ old('name') }}</textarea>
                <p class="error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="shop-register__item-image">
                <input type="file" class="auth-form__input" name="image">
                <p class="error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>


            <input class="shop-register__btn" type="submit" value="登録">
        </form>
    </div>

</div>
@stop