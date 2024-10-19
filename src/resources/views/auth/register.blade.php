@extends('layouts.app')

@section('content')
<div class="container">
    <h2>会員登録</h2>
    <form action="{{ route('register') }}" method="POST" novalidate>
        @csrf

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">確認用パスワード</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            @error('password_confirmation')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">登録する</button>
    </form>

    <a href="{{ route('login') }}">ログインはこちら</a>
</div>
@endsection