<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * 商品名で部分一致検索ができる
     */
    public function test_items_can_be_searched_by_name()
    {
        $matchingItem = Item::factory()->create(['name' => 'Matching Item']);
        $nonMatchingItem = Item::factory()->create(['name' => 'Unrelated Item']);

        $response = $this->get('/?query=Matching');

        $response->assertSee($matchingItem->name);
        $response->assertDontSee($nonMatchingItem->name);
    }

    /**
     * 検索状態がマイリストでも保持されている
     */
    public function test_search_query_is_preserved_in_mylist()
    {
        $user = User::factory()->create([
            'name' => 'ItemSearch',
            'email' => 'ItemSearch@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),  // テスト用にメール認証はスキップ
        ]);

        $likedMatchingItem = Item::factory()->create(['name' => 'Liked Matching Item']);
        $likedNonMatchingItem = Item::factory()->create(['name' => 'Liked Unrelated Item']);

        $user->likes()->attach($likedMatchingItem);
        $user->likes()->attach($likedNonMatchingItem);

        $this->actingAs($user);

        $response = $this->get('/?query=Matching');
        $response = $this->get('/?tab=mylist&query=Matching');

        $response->assertSee($likedMatchingItem->name);
        $response->assertDontSee($likedNonMatchingItem->name);
    }
}
