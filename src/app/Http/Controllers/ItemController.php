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
        $query = $request->get('query');  // 検索クエリ
        $userId = Auth::id();             // 現在のユーザーID
        $tab = $request->query('tab', 'recommend');  // デフォルトは'recommend'タブ

        if ($tab === 'mylist' && Auth::check()) {
            // マイリスト：ユーザーが「いいね」した商品に検索条件を適用
            $itemsQuery = Auth::user()->likes()->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'like', '%' . $query . '%');
            });
        } else {
            // おすすめ：自分の出品を除外し、検索条件を適用
            $itemsQuery = Item::when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'like', '%' . $query . '%');
            })->where('user_id', '!=', $userId);
        }

        // アイテムを取得
        $items = $itemsQuery->get();

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
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $user->likes()->attach($item->id);

        return response()->json(['likes_count' => $item->likedByUsers()->count()]);
    }

    public function unlike(Item $item)
    {
        $user = Auth::user();
        $user->likes()->detach($item->id);

        return response()->json(['likes_count' => $item->likedByUsers()->count()]);
    }
}
