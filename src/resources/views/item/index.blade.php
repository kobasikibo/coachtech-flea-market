@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item-index.css') }}" />
@endsection

@section('content')
    <div class="tab-container">
        <a href="{{ url('/') }}?tab=recommend&query={{ request('query', '') }}" class="tab-link {{ request('tab', 'recommend') === 'recommend' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ url('/') }}?tab=mylist&query={{ request('query', '') }}" class="tab-link {{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>

    <div class="item-list">
        @foreach($items as $item)
            <div class="item">
                <a href="{{ route('item.show', ['item_id' => $item->id]) }}">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}">
                </a>
                <div class="item-name">{{ $item->name }}</div>
                {{-- 購入済み表示は後回し --}}
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/item-index.js') }}" defer></script>
@endsection