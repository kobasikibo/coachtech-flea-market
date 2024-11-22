@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item-purchase.css') }}" />
@endsection

@section('content')
<form action="{{ route('purchase.store', ['item_id' => $item->id]) }}" method="POST" class="purchase">
    @csrf
    <div class="left-content">
        <div class="item-detail">
            <div class="item-image-container">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
            </div>

            <div class="item-info">
                <div class="item-name">{{ $item->name }}</div>
                <div class="price">
                    <span class="value">¥ {{ number_format($item->price) }}</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="payment_method" class="payment-label">支払い方法</label>
            <select name="payment_method" required>
                <option value="">選択してください</option>
                <option value="convenience" {{ old('payment_method') === 'convenience' ? 'selected' : '' }}>コンビニ支払い</option>
                <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>カード支払い</option>
            </select>
        </div>

        <div class="form-group">
            <div class="address-label">
                <label for="address">配送先</label>
                <a href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}" class="btn-change-address">
                変更する
                </a>
            </div>
            <div class="address-info">
                <p>〒 {{ $address->zip_code ?? '未登録' }}</p>
                <p>{{ $address->address ?? '未登録' }}</p>
                <p>{{ $address->building ?? '未登録' }}</p>
            </div>
        </div>
    </div>

    <div class="right-content">
        <div class="order-summary">
            <div class="summary-item">
                <p class="label">商品代金</p>
                <p class="value">¥ {{ number_format($item->price) }}</p>
            </div>
            <div class="summary-item">
                <p class="label">支払い方法</p>
                <p class="value">
                    <span id="payment-method-display">未選択</span>
                </p>
            </div>
        </div>
        <button type="submit" class="btn-purchase">購入する</button>
    </div>
</form>
@endsection

@section('scripts')
    <script src="{{ asset('js/item-purchase.js') }}"></script>
@endsection