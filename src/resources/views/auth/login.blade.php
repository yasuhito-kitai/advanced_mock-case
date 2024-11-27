@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@stop

@section('content')
<div class="auth-form">
    <div class="section-title">
        <h2 class="section-title__text">Login</h2>
    </div>

    <div class="auth-form__group">
        <form class="login-form__form" action="/login" method="post">
            @csrf
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

                <input class="auth-form__btn" type="submit" value="ログイン">
        </form>
    </div>
</div>
@stop