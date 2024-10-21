@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
@endsection

@section('content')
<h1>ログイン</h1>

<form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    <div class="form-group">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>

        @error('email')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">パスワード</label>
        <input type="password" name="password" class="form-input" required>

        @error('password')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn">ログインする</button>
</form>

<a href="{{ route('register') }}">会員登録はこちら</a>
@endsection