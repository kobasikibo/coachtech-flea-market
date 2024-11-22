<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Charge;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function charge($amount, $token)
    {
        Charge::create([
            'amount' => $amount * 100,
            'currency' => 'jpy',
            'source' => $token,
            'description' => '商品購入',
        ]);
    }
}