<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'coachtechフリマ')</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="header__container">
                <a class="header__logo" href="/">
                    <img src="{{ asset('images/logo.svg') }}" alt="coachtechフリマのロゴ">
                </a>
            </div>

            @if (!in_array(request()->route()->getName(), ['login', 'register']))
                <div class="header__container">
                    <div class="header__center">
                        <form class="search-form" action="/search" method="GET">
                            <input type="text" name="query" placeholder="なにをお探しですか？">
                        </form>
                    </div>
                </div>

                <div class="header__container">
                    <div class="header__links">
                        @auth
                            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                                @csrf
                                <button type="submit" class="link-style-button">ログアウト</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="link-login">ログイン</a>
                        @endauth
                        <a href="{{ route('mypage.show') }}" class="link-mypage">マイページ</a>
                        <a href="{{ route('item.create') }}" class="link-sell">出品</a>
                    </div>
                </div>
            @endif
        </div>
    </header>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>
</body>

</html>