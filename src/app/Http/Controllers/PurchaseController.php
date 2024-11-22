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

        // Stripe決済処理
        if ($validated['payment_method'] === 'card') {
            $stripeService->charge($item->price, $request->stripeToken);
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
            'payment_method' => $validated['payment_method'],
            'temp_zip_code' => $validated['zip_code'],
            'temp_address' => $validated['address'],
            'temp_building' => $validated['building']
        ]);

        return redirect('/');
    }
}
