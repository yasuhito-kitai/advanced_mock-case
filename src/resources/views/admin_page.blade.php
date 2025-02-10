@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_page.css') }}">
@stop

@section('content')

<div class="whole-container">
    <div class="auth-form">
        <div class="auth-section-title">
            <h2 class="section-title__text">店舗代表者登録</h2>
        </div>
        <div class="auth-form__group">
            <form class="auth-form__form" action="/register" method="post">
                @csrf
                <input type="hidden" name="role" value="owner">
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
                <div class="auth-form__button">
                    <input class="auth-form__button--btn" type="submit" value="登録">
                </div>
            </form>
        </div>

        <div class="import__box">
            <div class="section-title__text">店舗情報のインポート（csv）</div>
            <form class="import__form" action="/import-csv" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="csv_file" required>
                <button type="submit">インポート</button>
            </form>

            @if(session('success'))
            <p>{{ session('success') }}</p>
            @endif
            <!-- エラーメッセージを表示 -->
            @if($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>

    <div class="email__group">
        <div class="email-section-title">
            <h2 class="section-title__text">利用者へのお知らせメール</h2>
        </div>

        <div class="email-form__group">
            <form class="email__form" action="/admin-email/confirm" method="post">
                @csrf
                <div class="form-group">
                    <h2 class="item__header">宛先</h2>
                    <p class="item__content">利用者全員</p>
                </div>

                <h2 class="item__header">件名</h2>
                <div class="form-group">
                    <input class="item__content" type="text" name="subject" value="{{old('subject')}}">
                </div>

                <div class="error-message">
                    @error('subject')
                    <p class="error-message__text">{{ $message }}</p>
                    @enderror
                </div>

                <h2 class="item__header">本文</h2>
                <div class="form-group">
                    <textarea class="item__content" name="body">{{ old('body') }}</textarea>
                </div>

                <div class="error-message">
                    @error('body')
                    <p class="error-message__text">{{ $message }}</p>
                    @enderror
                </div>
                <div class="confirm-button">
                    <input class="confirm-button--btn" type="submit" value="確認画面へ">
                </div>
            </form>
        </div>
    </div>
</div>
@stop