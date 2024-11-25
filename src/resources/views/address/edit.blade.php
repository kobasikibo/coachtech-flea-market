@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/form-styles.css') }}" />
@endsection

@section('content')
    <h1>住所の変更</h1>

    <form action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="POST" novalidate>
        @csrf

        <div class="form-group">
            <label for="zip_code">郵便番号</label>
            <input type="text" name="zip_code" class="zip-code" value="{{ old('zip_code') }}" placeholder="{{ $defaultAddress['zip_code'] }}" required>
            @error('zip_code') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" class="address" value="{{ old('address') }}" placeholder="{{ $defaultAddress['address'] }}" required>
            @error('address') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" class="building" value="{{ old('building') }}" placeholder="{{ $defaultAddress['building'] }}" required>
            @error('building') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-update">更新する</button>
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('js/form-handler.js') }}"></script>
@endsection