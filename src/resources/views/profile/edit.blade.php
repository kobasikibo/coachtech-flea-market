@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- プロフィール画像 -->
        <div class="mb-3">
            <label for="profile_image" class="form-label">プロフィール画像</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" width="100">
            @endif
        </div>

        <!-- ユーザー名 -->
        <div class="mb-3">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- 郵便番号 -->
        <div class="mb-3">
            <label for="postal_cord" class="form-label">郵便番号</label>
            <input type="text" name="postal_cord" id="postal_cord" class="form-control" value="{{ old('postal_cord', $address->postal_cord ?? '') }}" required>
        </div>

        <!-- 住所 -->
        <div class="mb-3">
            <label for="address" class="form-label">住所</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $address->address ?? '') }}" required>
        </div>

        <!-- 建物名 -->
        <div class="mb-3">
            <label for="building" class="form-label">建物名</label>
            <input type="text" name="building" id="building" class="form-control" value="{{ old('building', $address->building ?? '') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection