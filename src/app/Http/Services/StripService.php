<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Charge;

Stripe::setApiKey(env('STRIPE_SECRET'));

try {
    $charge = Charge::create([
        'amount' => 5000, // テスト金額 (5000 = ¥50)
        'currency' => 'jpy',
        'source' => 'tok_visa', // テストトークン
        'description' => 'Test charge',
    ]);
    dd($charge);
} catch (\Exception $e) {
    dd($e->getMessage());
}

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        \Log::info('Using Stripe API key: ' . env('STRIPE_SECRET'));
    }

    public function charge($amount, $token)
    {
        if (!$token) {
            // トークンが無い場合（コンビニ支払い）は決済を行わない
            return;
        }

        // Stripeで決済処理を実行
        Charge::create([
            'amount' => $amount * 100, // 金額をセンチ単位に変換
            'currency' => 'jpy',
            'source' => $token, // フォームから送信されたStripeトークン
            'description' => '商品購入',
        ]);
    }
}