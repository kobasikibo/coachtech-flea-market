@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('content')

    <div class="profile-container">
        <!-- プロフィール画像 -->
        <div class="profile-image {{ $user->profile_image ? '' : 'default-profile' }}">
            @if($user->profile_image)
                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像">
            @else
                <span class="default-text">画像がありません</span>
            @endif
        </div>

        <!-- ユーザー名 -->
        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <a href="{{ route('profile.edit') }}" class="btn">プロフィールを編集</a>
        </div>

        <!-- タブの切り替え -->
        <div class="tabs">
            <ul class="tab-list">
                <li class="tab-item {{ request('tab') === 'sell' ? 'active' : '' }}">
                    <a href="{{ route('mypage.show', ['tab' => 'sell']) }}">出品した商品</a>
                </li>
                <li class="tab-item {{ request('tab') === 'buy' ? 'active' : '' }}">
                    <a href="{{ route('mypage.show', ['tab' => 'buy']) }}">購入した商品</a>
                </li>
            </ul>
        </div>

        <!-- 商品一覧 -->
        <div class="item-list">
            {{--
            @if(request('tab') === 'sell')
                <h3>出品した商品一覧</h3>
                @forelse($user->items as $item)
                    <div class="item-card">
                        <h4>{{ $item->name }}</h4>
                        <p>{{ $item->description }}</p>
                    </div>
                @empty
                    <p>出品した商品はありません。</p>
                @endforelse
            @else
                <h3>購入した商品一覧</h3>
                @forelse($user->items as $item)
                    <div class="item-card">
                        <h4>{{ $item->name }}</h4>
                        <p>{{ $item->description }}</p>
                    </div>
                @empty
                    <p>購入した商品はありません。</p>
                @endforelse
            @endif
            --}}
        </div>
    </div>
@endsection