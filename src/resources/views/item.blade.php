@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}" />
@endsection

@section('content')

@auth
    <div>
        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">ログアウト</button>
        </form>
    </div>

@else
    <div>
        <a href="{{ route('login') }}" class="btn-login">ログインする</a>
    </div>
@endauth

@endsection