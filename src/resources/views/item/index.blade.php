@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@section('header-center')
    <div class="header__center">
        <form class="search-form" action="/search" method="GET">
            <input type="text" name="query" placeholder="なにをお探しですか？">
            <button type="submit">検索</button>
        </form>
    </div>
@endsection

@section('header-right')
    <div class="header__right-links">
        @auth
            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="link-style-button">ログアウト</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="link-login">ログイン</a>
        @endauth
        <a href="{{ route('mypage.show') }}" class="link-mypage">マイページ</a>
    </div>
@endsection

@section('content')

@endsection