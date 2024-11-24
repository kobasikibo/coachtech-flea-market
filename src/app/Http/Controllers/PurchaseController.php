<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Services\StripeService;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        if ($user->address) {
            $address = [
                'zip_code' => session('temp_zip_code', $user->address->zip_code),
                'address' => session('temp_address', $user->address->address),
                'building' => session('temp_building', $user->address->building),
            ];
        } else {
            // 住所が登録されていない場合のデフォルト値
            $address = [
                'zip_code' => session('temp_zip_code', ''),
                'address' => session('temp_address', '住所'),
                'building' => session('temp_building', '建物名'),
            ];
        }

        return view('item.purchase', compact('item', 'address'));
    }

    public function store(PurchaseRequest $request, StripeService $stripeService)
    {
        $validated = $request->validated();
        $item = Item::findOrFail($request->item_id);
        $user = Auth::user();

        $tempZipCode = session('temp_zip_code', $user->address->zip_code);
        $tempAddress = session('temp_address', $user->address->address);
        $tempBuilding = session('temp_building', $user->address->building);

        // 購入処理
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => $validated['payment_method'],
            'address_id' => $user->address->id,
            'temp_zip_code' => $tempZipCode,
            'temp_address' => $tempAddress,
            'temp_building' => $tempBuilding,
        ]);

        // 支払い方法がカードの場合、Stripeで支払い処理
        if ($validated['payment_method'] === 'card') {
            $stripeService->charge($item->price, $request->stripeToken);
        }

        session()->forget(['temp_zip_code', 'temp_address', 'temp_building']);

        return redirect('/');
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        if ($user->address) {
            $defaultAddress = [
                'zip_code' => session('temp_zip_code', $user->address->zip_code),
                'address' => session('temp_address', $user->address->address),
                'building' => session('temp_building', $user->address->building),
            ];
        } else {
            $defaultAddress = [
                'zip_code' => session('temp_zip_code', ''),
                'address' => session('temp_address', ''),
                'building' => session('temp_building', ''),
            ];
        }

        return view('address.edit', compact('item', 'defaultAddress'));
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        $validated = $request->validated();

        // セッションに新しい住所情報を保存
        session([
            'temp_zip_code' => $validated['zip_code'],
            'temp_address' => $validated['address'],
            'temp_building' => $validated['building'],
        ]);

        // 住所変更後に購入画面にリダイレクト
        return redirect()->route('purchase.show', ['item_id' => $item_id])
                        ->with('success', '配送先住所を変更しました。');
    }
}