<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class ShippingAddressTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->user = User::factory()->create([
            'name' => 'ShippingAddress',
            'email' => 'shippingaddress@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $this->item = Item::first();
    }

    /**
     * 送付先住所変更画面にて登録した住所が商品購入画面に反映されている
     */
    public function test_registered_address_is_reflected_on_purchase_screen()
    {
        // ユーザーにログインする
        $this->actingAs($this->user);

        // 送付先住所変更画面で住所を登録する
        $newAddress = [
            'zip_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => '渋谷ビル101',
        ];
        $this->post(route('purchase.address.update', ['item_id' => $this->item->id]), $newAddress);

        // 商品購入画面を開く
        $response = $this->get(route('purchase.show', ['item_id' => $this->item->id]));

        // 登録した住所が商品購入画面に正しく反映される
        $response->assertStatus(200);
        $response->assertSee($newAddress['zip_code']);
        $response->assertSee($newAddress['address']);
        $response->assertSee($newAddress['building']);
    }

    /**
     * 購入した商品に送付先住所が紐づいて登録される
     */
    public function test_address_is_stored_in_purchase()
    {
        // ユーザーにログインする
        $this->actingAs($this->user);

        // 送付先住所変更画面で住所を登録する
        $newAddress = [
            'zip_code' => '123-4567',
            'address' => '東京都渋谷区1-2-3',
            'building' => '渋谷ビル101',
        ];
        $this->post(route('purchase.address.update', ['item_id' => $this->item->id]), $newAddress);

        // 商品を購入する
        $purchaseData = [
            'payment_method' => 'card',
            'item_id' => $this->item->id,
        ];
        $response = $this->post(route('purchase.store', $purchaseData));

        // 正しく送付先住所が紐づいている
        $purchase = Purchase::where('user_id', $this->user->id)
            ->where('item_id', $this->item->id)
            ->first();

        $this->assertEquals($newAddress['zip_code'], $purchase->shipping_zip_code);
        $this->assertEquals($newAddress['address'], $purchase->shipping_address);
        $this->assertEquals($newAddress['building'], $purchase->shipping_building);
    }
}
