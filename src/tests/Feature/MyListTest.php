<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * いいねした商品だけが表示される
     */
    public function test_only_liked_items_are_displayed()
    {
        $user = User::factory()->create([
            'name' => 'MyList',
            'email' => 'MyList@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),  // テスト用にメール認証はスキップ
        ]);

        $likedItem = Item::factory()->create();
        $unlikedItem = Item::factory()->create();

        $user->likes()->attach($likedItem);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertSee($likedItem->name);
        $response->assertDontSee($unlikedItem->name);
    }

    /**
     * 購入済み商品は「Sold」と表示される
     */
    public function test_sold_items_are_displayed_as_sold_in_mylist()
    {
        $user = User::factory()->create([
            'name' => 'MyList',
            'email' => 'MyList@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),  // テスト用にメール認証はスキップ
        ]);

        $item = Item::factory()->create(['is_purchased' => true]);

        $user->likes()->attach($item);

        $this->actingAs($user);
        $response = $this->get('/?tab=mylist');

        $response->assertSee('Sold');
    }

    /**
     * 自分が出品した商品は表示されない
     */
    public function test_own_items_are_not_displayed_in_mylist()
    {
        $user = User::factory()->create([
            'name' => 'MyList',
            'email' => 'MyList@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),  // テスト用にメール認証はスキップ
        ]);

        $myItem = Item::factory()->create(['user_id' => $user->id,]);

        $user->likes()->attach($myItem);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertDontSee($myItem->name);
    }

    /**
     * 未認証の場合は何も表示されない
     */
    public function test_mylist_is_empty_when_user_is_not_authenticated()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertViewHas('items');

        $items = $response->viewData('items');
        $this->assertEmpty($items);
    }
}