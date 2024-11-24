<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Services\StripeService;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $address = Auth::user()->address;
        return view('item.purchase', compact('item', 'address'));
    }

    public function store(PurchaseRequest $request, StripeService $stripeService)
    {
        $validated = $request->validated();
        $item = Item::findOrFail($request->item_id);

        // ユーザーのデフォルト住所を取得
        $user = Auth::user();
        $defaultAddress = $user->address;

        // 住所が変更された場合のみ保存
        $tempZipCode = $validated['zip_code'] !== $defaultAddress->zip_code ? $validated['zip_code'] : null;
        $tempAddress = $validated['address'] !== $defaultAddress->address ? $validated['address'] : null;
        $tempBuilding = $validated['building'] !== $defaultAddress->building ? $validated['building'] : null;

        // 購入情報を保存
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => $validated['payment_method'],
            'address_id' => $defaultAddress->id, // デフォルト住所のIDを保存
            'temp_zip_code' => $tempZipCode,
            'temp_address' => $tempAddress,
            'temp_building' => $tempBuilding
        ]);

        // 支払い処理
        if ($validated['payment_method'] === 'card') {
            $stripeService->charge($item->price, $request->stripeToken);
        }

        return redirect('/');
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        // デフォルト住所を取得
        $defaultAddress = $user->address;

        return view('address.edit', compact('item', 'defaultAddress'));
    }

    public function updateAddress(Request $request, $item_id)
    {
        $validated = $request->validate([
            'zip_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address'  => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        // セッションに一時住所を保存
        session([
            'temp_zip_code' => $validated['zip_code'],
            'temp_address' => $validated['address'],
            'temp_building' => $validated['building'],
        ]);

        return redirect()->route('item.purchase', ['item_id' => $item_id])
                        ->with('success', '配送先住所を変更しました。');
    }
}