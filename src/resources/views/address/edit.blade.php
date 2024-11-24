@extends('layouts.app')

@section('content')
<div class="address-form-container">
    <h2>住所の変更</h2>
    <form action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="zip_code">郵便番号</label>
            <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code', $defaultAddress->zip_code) }}" required>
            @error('zip_code') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $defaultAddress->address) }}" required>
            @error('address') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" id="building" value="{{ old('building', $defaultAddress->building) }}">
            @error('building') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn">更新する</button>
    </form>
</div>
@endsection
