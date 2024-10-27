@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}" />
@endsection

@section('content')
<h1>プロフィール設定</h1>

<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <!-- プロフィール画像 -->
    <div class="form-group">
        <label for="profile_image">プロフィール画像</label>
        <input type="file" name="profile_image" class="form-input">

        @if($user->profile_image)
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
        @endif

        @error('profile_image')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <!-- ユーザー名 -->
    <div class="form-group">
        <label for="name">ユーザー名</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>

        @error('name')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <!-- 郵便番号 -->
    <div class="form-group">
        <label for="zip_code">郵便番号</label>
        <input type="text" name="zip_code" class="form-input" value="{{ old('zip_code', $address->zip_code ?? '') }}" required>

        @error('zip_code')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <!-- 住所 -->
    <div class="form-group">
        <label for="address">住所</label>
        <input type="text" name="address" class="form-input" value="{{ old('address', $address->address ?? '') }}" required>

        @error('address')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <!-- 建物名 -->
    <div class="form-group">
        <label for="building">建物名</label>
        <input type="text" name="building" class="form-input" value="{{ old('building', $address->building ?? '') }}" required>

        @error('building')
            <div class="error-message">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn">更新する</button>
</form>
@endsection