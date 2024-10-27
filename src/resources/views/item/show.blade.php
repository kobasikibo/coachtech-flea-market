@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item-show.css') }}" />
@endsection

@section('content')
<div class="item-detail">
    <!-- 左側：商品画像 -->
    <div class="item-image-container">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
    </div>

    <!-- 右側：商品情報 -->
    <div class="item-info">
        <div class="item-name">{{ $item->name }}</div>
        <div class="brand-name">ブランド{{ $item->brand }}</div>

        <div class="price">
            ¥<span class="value">{{ number_format($item->price) }}</span> (税込)
        </div>

        <!-- アイコン一覧 -->
        <div class="item-icons">
            <img src="{{ asset('images/icons/like-icon.png') }}" alt="いいね" class="icon">
            <img src="{{ asset('images/icons/comment-icon.png') }}" alt="コメント" class="icon">
        </div>

        <!-- 商品説明 -->
        <div class="item-description-label">商品説明</div>
        <p class="item-description">{{ $item->description }}</p>

        <!-- 商品の情報 -->
        <h2 class="item-information-label">商品の情報</h2>

        <!-- カテゴリ一覧 -->
        <div class="item-categories">
            <span class="category-label">カテゴリー</span>
            @foreach ($item->categories as $category)
                <span class="category-name">{{ $category->name }}</span>
            @endforeach
        </div>

        <div class="item-condition">
            <span class="condition-label">商品の状態</span>
            <span class="condition">{{ $item->condition }}</span>
        </div>
    </div>
</div>
@endsection