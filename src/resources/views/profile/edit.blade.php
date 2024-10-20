@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <!-- プロフィール画像 -->
        <div class="mb-3">
            <label for="profile_image" class="form-label">プロフィール画像</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" width="100">
            @endif
            @error('profile_image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- ユーザー名 -->
        <div class="mb-3">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- 郵便番号 -->
        <div class="mb-3">
            <label for="zip_code" class="form-label">郵便番号</label>
            <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ old('zip_code', $address->zip_code ?? '') }}" required>
            @error('zip_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- 住所 -->
        <div class="mb-3">
            <label for="address" class="form-label">住所</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $address->address ?? '') }}" required>
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- 建物名 -->
        <div class="mb-3">
            <label for="building" class="form-label">建物名</label>
            <input type="text" name="building" id="building" class="form-control" value="{{ old('building', $address->building ?? '') }}" required>
            @error('building')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection