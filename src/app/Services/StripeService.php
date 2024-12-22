<?php

namespace App\Services;

use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Models\Purchase;
use App\Models\Item;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function createCheckoutSession(Purchase $purchase, Item $item, $paymentMethod)
    {
        // 支払い方法（コンビニ支払いまたはカード支払い）に合わせた決済設定
        $paymentMethodTypes = ['card'];
        if ($paymentMethod === 'convenience') {
            $paymentMethodTypes = ['konbini'];
        }

        // Checkoutセッションを作成
        $checkoutSession = Session::create([
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => (int) $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('item.index'),
            'cancel_url' => route('purchase.show', ['item_id' => $item->id]),
        ]);

        return $checkoutSession->url;
    }
}