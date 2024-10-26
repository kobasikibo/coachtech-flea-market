@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}" />
@endsection

@section('content')
    <div class="profile-container">
        <div class="user-info">
            <div class="image-container">
                @if($user->image_path)
                    <img src="{{ asset('storage/' . $user->image_path) }}" alt="User Image" class="user-image">
                @endif
            </div>
            <div class="user-name">{{ $user->name }}</div>
            <a href="{{ route('profile.edit') }}" class="edit-profile-link">プロフィールを編集</a>
        </div>

        <div class="tab-container">
            <a href="#" class="tab-link active">出品した商品</a>
            <a href="#" class="tab-link disabled">購入した商品（未実装）</a>
        </div>

        <div class="item-list">
            @foreach($items as $item)
                <div class="item">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
                    <div class="item-name">{{ $item->name }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/profile.js') }}" defer></script>
@endsection