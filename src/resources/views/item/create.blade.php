@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/item-create.css') }}" />
@endsection

@section('content')
    <h1>商品の出品</h1>

    @if ($errors->any())
        <div class="error">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li class="error-item">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="image-label">商品画像</div>
        <div class="image-container">
            <img class="image" src="" alt="Image">
            <input type="file" name="image" class="image-upload" required accept=".jpeg,.png" onchange="previewImage(event)">
            <label class="upload-button" onclick="document.querySelector('.image-upload').click();">画像を選択する</label>
        </div>

        <!-- 商品の詳細セクション -->
        <h2 class="section-title">商品の詳細</h2>

        <div class="category-label">カテゴリー</div>
            @foreach ($categories as $category)
                <div class="category-item">
                    <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="category-{{ $loop->index }}" class="category-checkbox">
                    <label class="category" for="category-{{ $loop->index }}">{{ $category->name }}</label>
                </div>
            @endforeach

        <div class="form-group">
            <div class="condition-label">商品の状態</div>
            <select name="condition" class="form-input" required>
                <option value="" class="disabled" disabled selected hidden>選択してください</option>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition }}">{{ $condition }}</option>
                @endforeach
            </select>
        </div>

        <h2 class="section-title">商品名と説明</h2>

        <div class="form-group">
            <div class="name-label">商品名</div>
            <input type="text" name="name" class="form-input" required>
        </div>

        <div class="form-group">
            <div class="brand-label">ブランド名</div>
            <input type="text" name="brand" class="form-input">
        </div>

        <div class="form-group">
            <div class="description-label">商品の説明</div>
            <textarea rows="3" name="description" class="form-input" required></textarea>
        </div>

        <div class="form-group">
            <div class="price-label">販売価格</div>
            <input type="text" name="price" class="form-input" required>
        </div>

        <button type="submit" class="btn-submit">出品する</button>
    </form>

@endsection

@section('scripts')
    <script src="{{ asset('js/item-create.js') }}"></script>
@endsection