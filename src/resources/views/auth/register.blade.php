@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/register.css') }}" />
@endsection

@section('content')
    <h1>会員登録</h1>

    <form action="{{ route('register') }}" method="POST" novalidate>
        @csrf

        <div class="form-group">
            <div class="name-label">ユーザー名</div>
            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>

            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="email-label">メールアドレス</div>
            <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>

            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="password-label">パスワード</div>
            <input type="password" name="password" class="form-input" required>

            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="password-confirmation-label">確認用パスワード</div>
            <input type="password" name="password_confirmation" class="form-input" required>

            @error('password_confirmation')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">登録する</button>
    </form>

    <a href="{{ route('login') }}" class="auth-link">ログインはこちら</a>
@endsection