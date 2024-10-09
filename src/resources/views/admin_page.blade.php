@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@stop

@section('content')
<div class="auth-form">
    <h2 class="section-title">店舗代表者登録</h2>
    <div class="auth-form__group">
        <form class="auth-form__form" action="/register" method="post">
            @csrf
            <input type="hidden" name="role" value="owner">
            <div class="auth-form__item">
                <input class="auth-form__input" type="text" name="name" placeholder="Username" value="{{ old('name') }}">
                <p class="error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="auth-form__item">
                <input class="auth-form__input" type="text" name="email" placeholder="Email" value="{{ old('email') }}">
                <p class="error-message">
                    @error('email')
                    {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="auth-form__item">
                <input class="auth-form__input" type="password" name="password" placeholder="Password">
                <p class="error-message">
                    @error('password')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <input class="auth-form__btn" type="submit" value="登録">
        </form>
    </div>


@stop