<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index()
    {
        return view('item.index');
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
        ]);

        $item->categories()->attach($request->category_ids);

        return redirect()->route('item.index')->with('success', '商品を出品しました。');
    }
}
