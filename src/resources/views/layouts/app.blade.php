<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="nav">
            <input id="drawer__input" class="drawer__hidden" type="checkbox">
            <label for="drawer__input" class="drawer__open"><span></span></label>
            <nav class="nav__content">
                <ul class="nav__list">
                    <!-- ログアウト中のメニュー表示 -->
                    @guest
                    <li class="nav__item"><a href="/">Home</a></li>
                    <li class="nav__item"><a href="/register">Registration</a></li>
                    <li class="nav__item"><a href="/login">Login</a></li>
                    @endguest

                    <!-- ログイン中のメニュー表示 -->
                    @auth
                    <li class="nav__item"><a href="/">Home</a></li>
                    <li class="nav__item">
                        <form action="/logout" method="post">
                            @csrf
                            <input class="logout" type="submit" value="Logout">
                        </form>
                    </li>
                    <li class="nav__item"><a href="/mypage">Mypage</a></li>

                    @can('admin')<!-- 管理者のみ表示 -->
                    <li class="nav__item"><a href="/admin-page">Admin-page</a></li>
                    @endcan

                    @can('owner')<!-- 店舗代表者のみ表示 -->
                    <li class="nav__item"><a href="/owner-page">Owner-page</a></li>
                    @endcan
                    @endauth
                </ul>
            </nav>
        </div>

        <div class="logo">Rese</div>

        @yield('header')
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>