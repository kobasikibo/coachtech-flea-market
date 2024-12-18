@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}" />
@endsection

@section('content')
    <h1>プロフィール設定</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <div class="image-group">
            <div class="image-container">
                <img
                    src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : '' }}"
                    class="image-preview">
            </div>
            <label class="file-label">
                画像を選択する
                <input type="file" name="profile_image" class="image-input" >
            </label>

            @error('profile_image')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="name-label">ユーザー名</div>
            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>

            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="zip-code-label">郵便番号</div>
            <input type="text" name="zip_code" class="form-input" value="{{ old('zip_code', $address->zip_code ?? '') }}" required>

            @error('zip_code')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="address-label">住所</div>
            <input type="text" name="address" class="form-input" value="{{ old('address', $address->address ?? '') }}" required>

            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="building-label">建物名</div>
            <input type="text" name="building" class="form-input" value="{{ old('building', $address->building ?? '') }}" required>

            @error('building')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-submit">更新する</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/profile-edit.js') }}"></script>
@endsection