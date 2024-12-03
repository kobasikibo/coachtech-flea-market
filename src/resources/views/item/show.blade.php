@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item-show.css') }}" />
@endsection

@section('content')
<div class="item-detail">
    <div class="item-image-container">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
    </div>

    <div class="item-info">
        <div class="item-name">{{ $item->name }}</div>
        <div class="brand-name">{{ $item->brand }}</div>

        <div class="price">
            ¥<span class="value">{{ number_format($item->price) }}</span> (税込)
        </div>

        <div class="item-icons">
            <form action="{{ route('item.like', ['item_id' => $item->id]) }}" method="POST" class="like-form">
                @csrf
                <button type="submit" class="like-button {{ $item->likedByUsers()->where('user_id', auth()->id())->exists() ? 'liked' : '' }}" data-item-id="{{ $item->id }}">
                    <img src="{{ asset('images/icons/like-icon.png') }}" alt="いいね" class="icon">
                    <span class="likes-count">{{ $item->likedByUsers()->count() }}</span>
                </button>
            </form>
            <div class="comment-icon">
                <img src="{{ asset('images/icons/comment-icon.png') }}" alt="コメント" class="icon">
                <span class="comments-count">{{ $item->comments()->count() }}</span>
            </div>
        </div>

        <div class="purchase-button-container">
            <a href="{{ route('purchase.show', ['item_id' => $item->id]) }}" class="submit-button">購入手続きへ</a>
        </div>

        <h2 class="item-description-label">商品説明</h2>
        <p class="item-description">{{ $item->description }}</p>

        <h2 class="item-information-label">商品の情報</h2>

        <!-- カテゴリ一覧 -->
        <div class="item-categories">
            <span class="category-label">カテゴリー</span>
            <div class="categories">
                @foreach ($item->categories as $category)
                    <span class="category-name">{{ $category->name }}</span>
                @endforeach
            </div>
        </div>

        <div class="item-condition">
            <span class="condition-label">商品の状態</span>
            <span class="condition">{{ $item->condition }}</span>
        </div>

        <!-- コメント一覧 -->
        <h2 class="comment-label">コメント（{{ $item->comments()->count() }}）</h2>
        <div class="comments-section">
        @foreach ($item->comments()->latest()->get() as $comment)
            <div class="comment">
                <div class="user-info">
                    <div class="user-image-container">
                        @if($comment->user->profile_image)
                            <img src="{{ asset('storage/' . $comment->user->profile_image) }}" class="user-image">
                        @endif
                    </div>
                    <span class="user-name">{{ $comment->user->name }}</span>
                </div>
                <div class="comment-content">
                    <p>{{ $comment->content }}</p>
                </div>
            </div>
        @endforeach
        </div>

        <div class="comment-form">
            <form action="{{ route('comments.store', ['item_id' => $item->id]) }}" method="POST">
                @csrf
                <label for="comment-content" class="comment-form-label">商品へのコメント</label>
                <textarea name="content" rows="3" required maxlength="255">{{ old('content') }}</textarea>
                @error('content')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <button type="submit" class="submit-button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        window.isAuthenticated = @json(auth()->check());
    </script>
    <script src="{{ asset('js/item-show.js') }}"></script>
@endsection