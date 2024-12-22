<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use App\Models\Item;
use App\Models\Purchase;
use App\Services\StripeService;
use Illuminate\Support\Facades\Auth;

class PurchaseController
{
    private function getAddressFromSessionOrUser($user)
    {
        return [
            'zip_code' => session('shipping_zip_code', $user->address->zip_code ?? ''),
            'address' => session('shipping_address', $user->address->address ?? ''),
            'building' => session('shipping_building', $user->address->building ?? ''),
        ];
    }

    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $address = $this->getAddressFromSessionOrUser($user);

        return view('item.purchase', compact('item', 'address'));
    }

    protected $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function store(PurchaseRequest $request)
    {
        $validated = $request->validated();
        $item = Item::findOrFail($request->item_id);
        $user = Auth::user();

        $shippingAddress = $this->getAddressFromSessionOrUser($user);

        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => $validated['payment_method'],
            'shipping_zip_code' => $shippingAddress['zip_code'],
            'shipping_address' => $shippingAddress['address'],
            'shipping_building' => $shippingAddress['building'],
        ]);

        $item->is_purchased = true;
        $item->save();
        session()->forget(['shipping_zip_code', 'shipping_address', 'shipping_building']);

        return redirect($this->stripeService->createCheckoutSession($purchase, $item, $validated['payment_method']));
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        $defaultAddress = $this->getAddressFromSessionOrUser($user);

        return view('address.edit', compact('item', 'defaultAddress'));
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        $validated = $request->validated();

        session([
            'shipping_zip_code' => $validated['zip_code'],
            'shipping_address' => $validated['address'],
            'shipping_building' => $validated['building'],
        ]);

        return redirect()->route('purchase.show', ['item_id' => $item_id])
                        ->with('success', '配送先住所を変更しました。');
    }
}