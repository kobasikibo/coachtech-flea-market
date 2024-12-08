<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController
{
    // Stripeの公開可能キーとシークレットキーを設定（テスト環境用）
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    // Checkoutセッションを作成
    public function createCheckoutSession(Request $request, StripeService $stripeService)
    {
        $item = Item::findOrFail($request->item_id);
        $user = Auth::user();

        // 購入情報の保存
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method' => $request->payment_method,
            'temp_zip_code' => $user->address->zip_code,
            'temp_address' => $user->address->address,
            'temp_building' => $user->address->building,
        ]);

        // 支払い方法がカードの場合、Stripe Checkoutセッションを作成
        if ($request->payment_method === 'card') {
            try {
                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => 'jpy',
                                'product_data' => [
                                    'name' => $item->name,
                                ],
                                'unit_amount' => $item->price * 100, // 金額はセント単位
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'mode' => 'payment',
                    'success_url' => route('payment.success', ['purchase_id' => $purchase->id]),
                    'cancel_url' => route('payment.cancel', ['purchase_id' => $purchase->id]),
                ]);

                return response()->json(['id' => $session->id]);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }

        // コンビニ支払いの場合、処理をスキップ（Stripe決済を実行しない）
        return redirect()->route('payment.success', ['purchase_id' => $purchase->id]);
    }

    // 支払い成功後の処理
    public function success($purchase_id)
    {
        $purchase = Purchase::findOrFail($purchase_id);
        // 購入完了ページへリダイレクト
        return view('payment.success', compact('purchase'));
    }
}