<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class LikeItemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * いいねした商品として登録され、いいね合計値が増加表示される
     */
    public function test_item_can_be_liked_and_like_count_increases()
    {
        $user = User::factory()->create([
            'name' => 'likeItem',
            'email' => 'likeItem@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('item.show', ['item_id' => $item->id]));

        $initialLikeCount = $item->likedByUsers()->count();

        $this->post(route('item.like', ['item_id' => $item->id]));

        $response = $this->get(route('item.show', ['item_id' => $item->id]));
        $response->assertSee((string)($initialLikeCount + 1)); // いいね数が1増えていることを確認
    }

    /**
     * 追加済みのアイコンは色が変化する
     */
    public function test_like_icon_changes_color_when_item_is_liked()
    {
        $user = User::factory()->create([
            'name' => 'likeItem',
            'email' => 'likeItem@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('item.show', ['item_id' => $item->id]));
        $response->assertDontSee('liked');  // 初期状態では「いいね」アイコンは色が変わっていない

        $this->post(route('item.like', ['item_id' => $item->id]));

        $response = $this->get(route('item.show', ['item_id' => $item->id]));
        $response->assertSee('liked');  // アイコンに「liked」クラスが追加されている
    }

    /**
     * 再度いいねアイコンを押下することによって、いいねを解除することができる
     */
    public function test_item_like_can_be_removed()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'likeuser@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('item.show', ['item_id' => $item->id]));

        $initialLikeCount = $item->likedByUsers()->count();

        $this->post(route('item.like', ['item_id' => $item->id]));

        $response = $this->get(route('item.show', ['item_id' => $item->id]));
        $response->assertSee((string)($initialLikeCount + 1));

        $this->post(route('item.like', ['item_id' => $item->id]));

        $response = $this->get(route('item.show', ['item_id' => $item->id]));
        $response->assertSee((string)($initialLikeCount));
    }
}