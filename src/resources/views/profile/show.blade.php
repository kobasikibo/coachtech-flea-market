@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/exhibition.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/profile-show.css') }}" />
@endsection

@section('content')
    <div class="profile-container">
        <div class="user-info">
            <div class="image-container">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" class="user-image">
                @endif
            </div>
            <div class="user-name">{{ $user->name }}</div>
            <a href="{{ route('profile.edit') }}" class="edit-profile-link">プロフィールを編集</a>
        </div>

        <div class="tab-container">
            <a href="{{ url('/mypage?tab=sell') }}" class="tab-link {{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
            <a href="{{ url('/mypage?tab=buy') }}" class="tab-link {{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
        </div>

        <div class="item-list">
            @foreach($items as $item)
                <div class="item @if($item->is_purchased) sold @endif">
                    <div class="item-img-container">
                        <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                        </a>
                        @if($item->is_purchased)
                            <div class="sold-label">Sold</div>
                        @endif
                    </div>
                    <div class="item-name">{{ $item->name }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/profile-show.js') }}" defer></script>
@endsection