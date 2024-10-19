@extends('layouts.app')

@section('content')
<div class="container">
    <h2>ログイン</h2>
    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf
        <div>
            <label for="email">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="password">パスワード</label>
            <input type="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">ログインする</button>
    </form>

    <a href="{{ route('register') }}">会員登録はこちら</a>
</div>
@endsection