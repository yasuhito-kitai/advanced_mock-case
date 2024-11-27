@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@stop

@section('content')
<div class="auth-form">
    <div class="section-title">
        <h2 class="section-title__text">Registration</h2>
    </div>
    <div class="auth-form__group">
        <form class="auth-form__form" action="/register" method="post">
            @csrf
            <input type="hidden" name="role" value="general">
            <div class="auth-form__item">
                <div class="person-icon">
                    <img class="person-icon__img" src="img/人物アイコン.png">
                </div>
                <input class="auth-form__input" type="text" name="name" placeholder="Username" value="{{ old('name') }}">
            </div>

            <div class="error-message">
                @error('name')
                <p class="error-message__text">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form__item">
                <div class="email-icon">
                    <img class="email-icon__img" src="img/メールのアイコン.png">
                </div>
                <input class="auth-form__input" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
            </div>

            <div class="error-message">
                @error('email')
                <p class="error-message__text">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-form__item">
                <div class="key-icon">
                    <img class="key-icon__img" src="img/カギアイコン.png">
                </div>
                <input class="auth-form__input" type="password" name="password" placeholder="Password">
            </div>

            <div class="error-message">
                @error('password')
                <p class="error-message__text">{{ $message }}</p>
                @enderror
            </div>

            <input class="auth-form__btn" type="submit" value="登録">
        </form>
    </div>
</div>
@stop