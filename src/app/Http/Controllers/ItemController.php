<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(SearchRequest $request)
    {
        $query = $request->get('query');
        $userId = Auth::id();
        $tab = request()->query('tab', 'recommend');

        // 検索クエリの適用とタブごとの商品取得
        $items = Item::when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'like', '%' . $query . '%');
            });

        if ($tab === 'mylist' && Auth::check()) {
            // マイリストに切り替えた場合の処理。未認証なら何も表示しない。
            $items = Auth::user()->likedItems(); // likedItemsリレーションの利用
        } else {
            // おすすめ商品（デフォルト）の取得。自分の出品は除外。
            $items = $items->where('user_id', '!=', $userId)->get();
        }

        return view('item.index', compact('items', 'tab', 'query'));
    }


    public function show($item_id)
    {
        $item = Item::with(['categories', ])->findOrFail($item_id);

        return view('item.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = config('condition');

        return view('item.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $path = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'image_path' => $path,
            'condition' => $request->condition,
            'price' => $request->price,
            'user_id' => Auth::id(),
        ]);

        $item->categories()->attach($request->category_ids);

        return redirect()->route('item.index')->with('success', '商品を出品しました。');
    }

    public function like(Item $item)
    {
        $item->likedByUsers()->attach(auth()->id());

        return response()->json([
            'likes_count' => $item->likedByUsers()->count(),
        ]);
    }

    public function unlike(Item $item)
    {
        $item->likedByUsers()->detach(auth()->id());

        return response()->json([
            'likes_count' => $item->likedByUsers()->count(),
        ]);
    }
}
