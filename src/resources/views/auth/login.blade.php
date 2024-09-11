@extends('layouts.app')

@section('content')
<div class="auth-form">
    <h2 class="section-title">ログイン</h2>
    <div class="auth-form__group">
        <form class="login-form__form" action="/login" method="post">
            @csrf
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

            <input class="auth-form__btn" type="submit" value="ログイン">
        </form>
    </div>
</div>
@stop