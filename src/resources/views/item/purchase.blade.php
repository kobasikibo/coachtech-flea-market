@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item-purchase.css') }}" />
@endsection

@section('content')
<form action="{{ route('purchase.store', ['item_id' => $item->id]) }}" method="POST" class="purchase" id="purchase-form">
    @csrf
    <div class="left-content">
        <div class="item-detail">
            <div class="item-image-container">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-image">
            </div>

            <div class="item-info">
                <div class="item-name">{{ $item->name }}</div>
                <div class="price">
                    <span class="value"><span class="currency-symbol">¥ </span>{{ number_format($item->price) }}</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="payment-label-container">
                <div class="payment-label">支払い方法</div>
                @error('payment_method')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <select name="payment_method" required>
                <option value="convenience" disabled selected hidden>選択してください</option>
                <option value="convenience" {{ old('payment_method') === 'convenience' ? 'selected' : '' }}>コンビニ支払い</option>
                <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>カード支払い</option>
            </select>
        </div>

        <div class="form-group">
            <div class="label-container">
                <div class="address-label">配送先</div>
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
                <a href="{{ route('purchase.address.edit', ['item_id' => $item->id]) }}" class="btn-change-address">変更する</a>
            </div>
            <div class="address-info">
                @if (!empty($address['zip_code']))
                    <p>〒 {{ $address['zip_code'] }}</p>
                @endif
                <p>{{ $shippingAddress ?? $address['address'] ?? '' }}<p>
                <p>{{ $shippingBuilding ?? $address['building'] ?? '' }}</p>
            </div>
        </div>
    </div>

    <div class="right-content">
        <div class="order-summary">
            <div class="summary-item">
                <p class="summary-label">商品代金</p>
                <p class="summary-value"><span class="currency-symbol">¥ </span>{{ number_format($item->price) }}</p>
            </div>
            <div class="summary-item">
                <p class="summary-label">支払い方法</p>
                <p class="summary-value"><span id="payment-method-display"></span></p>
            </div>
        </div>
        <button type="submit" class="btn-purchase">購入する</button>
    </div>
</form>
@endsection

@section('scripts')
    <script src="{{ asset('js/item-purchase.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
@endsection