@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/create.css') }}" />
@endsection

@section('content')
    <h1>商品の出品</h1>

    @if ($errors->any())
        <div class="error-messages">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li class="error-item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <label class="image-label">商品画像</label>
        <div class="image-container">
            <img class="image" src="" alt="Image">
            <input type="file" name="image" class="image-upload" required accept=".jpeg,.png" onchange="previewImage(event)">
            <label class="upload-button" onclick="document.querySelector('.image-upload').click();">画像を選択する</label>
        </div>

        <!-- 商品の詳細セクション -->
        <h2 class="section-title">商品の詳細</h2>

        <h3 class="subsection-title">カテゴリー</h3>
        <div class="category-list">
            @foreach ($categories as $category)
                <div class="category-item">
                    <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="category-{{ $loop->index }}" class="category-checkbox">
                    <label class="category-label" for="category-{{ $loop->index }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>

        <h3 class="subsection-title">商品の状態</h3>
        <div class="condition">
            <select name="condition" class="condition-select" required>
                <option value="" disabled selected hidden>選択してください</option>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition }}">{{ $condition }}</option>
                @endforeach
            </select>
        </div>

        <!-- 商品名と説明セクション -->
        <h2 class="section-title">商品名と説明</h2>

        <div class="name">
            <label class="name-label">商品名</label>
            <input type="text" name="name" class="name-input" required>
        </div>

        <div class="brand">
            <label class="brand-label">ブランド名</label>
            <input type="text" name="brand" class="brand-input" >
        </div>

        <div class="description">
            <label class="description-label">商品の説明</label>
            <textarea name="description" class="description-textarea" required maxlength="255"></textarea>
        </div>

        <div class="price">
            <label class="price-label">販売価格</label>
            <input type="number" name="price" class="price-input" required min="0">
        </div>

        <button type="submit" class="submit-button">出品する</button>
    </form>

@endsection

@section('scripts')
    <script src="{{ asset('js/item-create.js') }}"></script>
@endsection