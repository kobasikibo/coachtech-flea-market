@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
<h2>会員登録</h2>

<form action="{{ route('register') }}" method="POST" novalidate>
    @csrf

    <div class="form-group">
        <label for="name">ユーザー名</label>
        <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>

        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

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

    <div class="form-group">
        <label for="password_confirmation">確認用パスワード</label>
        <input type="password" name="password_confirmation" class="form-input" required>

        @error('password_confirmation')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn">登録する</button>
</form>

<a href="{{ route('login') }}">ログインはこちら</a>
@endsection