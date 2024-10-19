@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ホーム</h1>

    @auth
        <div>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        <div>
            <a href="{{ route('login') }}">ログインする</a>
        </div>
    @endauth

</div>
@endsection