@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address-edit.css') }}" />
@endsection

@section('content')
    <h1>住所の変更</h1>

    <form action="{{ route('purchase.address.update', ['item_id' => $item->id]) }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="zip_code">郵便番号</label>
            <input type="text" name="zip_code" class="zip-code" id="zip_code" value="{{ old('zip_code', $defaultAddress['zip_code']) }}" required>
            @error('zip_code') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" name="address" class="address" id="address" value="{{ old('address', $defaultAddress['address']) }}" required>
            @error('address') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" name="building" class="building" id="building" value="{{ old('building', $defaultAddress['building']) }}">
            @error('building') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-update">更新する</button>
    </form>
@endsection