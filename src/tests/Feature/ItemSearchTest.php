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
        // 検索対象となるアイテム
        $matchingItem = Item::factory()->create(['name' => 'Matching Item']);
        $nonMatchingItem = Item::factory()->create(['name' => 'Unrelated Item']);

        // 検索クエリを送信
        $response = $this->get('/?query=Matching');

        // 検索結果に部分一致する商品が表示される
        $response->assertSee($matchingItem->name);

        // 検索結果に一致しない商品は表示されない
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

        // マッチするアイテムを作成
        $likedMatchingItem = Item::factory()->create(['name' => 'Liked Matching Item']);
        // マッチしないアイテムを作成
        $likedNonMatchingItem = Item::factory()->create(['name' => 'Liked Unrelated Item']);

        // ユーザーがアイテムに「いいね」する
        $user->likes()->attach($likedMatchingItem);
        $user->likes()->attach($likedNonMatchingItem);

        // ユーザーをログインさせる
        $this->actingAs($user);

        // ホームページで検索クエリを入力して検索
        $response = $this->get('/?query=Matching');

        // 検索状態のままマイリストタブに移動
        $response = $this->get('/?tab=mylist&query=Matching');

        // マイリストに部分一致する商品が表示される
        $response->assertSee($likedMatchingItem->name);

        // 部分一致しないアイテムは表示されない
        $response->assertDontSee($likedNonMatchingItem->name);
    }
}
