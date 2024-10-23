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

        <div class="image-preview-container">
            <img class="image-preview hidden" src="" alt="Image Preview">
            <input type="file" name="image" class="image-upload" required accept=".jpeg,.png" onchange="previewImage(event)">
            <label class="upload-button" onclick="document.querySelector('.image-upload').click();">画像を選択する</label>
        </div>

        <!-- 商品の詳細セクション -->
        <h2 class="section-title">商品の詳細</h2>

        <div class="category-selection">
            <label class="category-label">カテゴリー</label>
            @foreach ($categories as $category)
                <div class="category-item">
                    <input type="checkbox" name="categories[]" value="{{ $category }}" id="category-{{ $loop->index }}" class="category-checkbox">
                    <label class="categories" for="category-{{ $loop->index }}">{{ $category }}</label> <!-- ラベルをcheckboxと連動 -->
                </div>
            @endforeach
        </div>

        <div class="item-condition">
            <label class="condition-label">商品の状態</label>
            <select name="condition" class="condition-select" required>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition }}">{{ $condition }}</option>
                @endforeach
            </select>
        </div>

        <!-- 商品名と説明セクション -->
        <h2 class="section-title">商品名と説明</h2>

        <div class="item-name">
            <label class="name-label">商品名</label>
            <input type="text" name="name" class="name-input" required>
        </div>

        <div class="item-description">
            <label class="description-label">商品の説明</label>
            <textarea name="description" class="description-textarea" required></textarea>
        </div>

        <div class="item-price">
            <label class="price-label">販売価格</label>
            <input type="number" name="price" class="price-input" required min="0">
        </div>

        <button type="submit" class="submit-button">出品する</button>
    </form>

    <script>
        function previewImage(event) {
            const preview = document.querySelector('.image-preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.add('show'); // 'show'クラスを追加
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection