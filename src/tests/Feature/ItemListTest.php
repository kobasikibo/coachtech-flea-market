<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    /**
     * 全商品を取得できる
     */
    public function test_can_get_all_items()
    {
        $response = $this->get('/');

        $response->assertViewHas('items');
        $items = $response->viewData('items');
        $this->assertCount(10, $items);
    }

    /**
     * 購入済み商品は「Sold」と表示される
     */
    public function test_sold_items_are_displayed_as_sold()
    {
        $user = User::factory()->create([
            'name' => 'ItemList',
            'email' => 'ItemList@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),  // テスト用にメール認証はスキップ
        ]);

        $item = Item::factory()->create(['is_purchased' => true]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertSee('Sold');
    }

    /**
     * 自分が出品した商品は表示されない
     */
    public function test_own_items_are_not_displayed()
    {
        $user = User::factory()->create([
            'name' => 'ItemList',
            'email' => 'ItemList@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),  // テスト用にメール認証はスキップ
        ]);

        $myItem = Item::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertDontSee($myItem->name);
    }
}
