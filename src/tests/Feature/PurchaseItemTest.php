<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class PurchaseItemTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->user = User::factory()->create([
            'name' => 'PurchaseUser',
            'email' => 'purchaseuser@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $this->item = Item::first();
    }

    /**
     * セッションに配送情報を設定する
     */
    protected function setShippingInfo()
    {
        session()->put('shipping_zip_code', '123-4567');
        session()->put('shipping_address', '東京都渋谷区1-2-3');
        session()->put('shipping_building', '渋谷ビル101');
    }

    /**
     * 商品購入処理を完了させる
     */
    protected function completePurchase($paymentMethod = 'card')
    {
        // ユーザーにログイン
        $this->actingAs($this->user);

        // 商品購入画面を開く
        $response = $this->get(route('purchase.show', ['item_id' => $this->item->id]));
        $response->assertStatus(200);
        $response->assertSee('購入する');

        $this->setShippingInfo();

        // 商品購入ボタンを押下
        $response = $this->post(route('purchase.store', ['item_id' => $this->item->id]), [
            'payment_method' => $paymentMethod,
        ]);

        return $response;
    }

    /**
     * 「購入する」ボタンを押下すると購入が完了する
     */
    public function test_user_can_complete_purchase()
    {
        // 商品購入処理を完了させる
        $response = $this->completePurchase('card');

        // 購入が完了する
        $response->assertRedirect(route('item.index'));
        $this->assertDatabaseHas('purchases', [
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
            'payment_method' => 'card',
            'shipping_zip_code' => '123-4567',
            'shipping_address' => '東京都渋谷区1-2-3',
            'shipping_building' => '渋谷ビル101',
        ]);
    }

    /**
     * 購入した商品は商品一覧画面にて「sold」と表示される
     */
    public function test_purchased_item_is_marked_as_sold_in_item_list()
    {
        // 商品購入処理を完了させる
        $response = $this->completePurchase('card');

        // 商品一覧画面を表示する
        $response->assertRedirect(route('item.index'));

        // 購入した商品が「sold」として表示されている
        $this->get(route('item.index'))->assertSee('Sold');
    }

    /**
     * 「プロフィール/購入した商品一覧」に追加されている
     */
    public function test_purchased_item_is_added_to_profile_purchase_list()
    {
        // 商品購入処理を完了させる
        $this->completePurchase('card');

        // プロフィール画面を表示する
        $response = $this->get(route('mypage.show', ['tab' => 'buy', 'user_id' => $this->user->id]));

        // 購入した商品がプロフィールの購入した商品一覧に追加されている
        $response->assertSeeText($this->item->name);
    }
}