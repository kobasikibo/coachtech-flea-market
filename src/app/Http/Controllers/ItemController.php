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

        // 商品の取得
        $items = Item::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', '%' . $query . '%');
        })
        ->where('user_id', '!=', $userId) // 自分が出品した商品は除外
        ->get();

        return view('item.index', compact('items'));
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
}
