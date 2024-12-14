<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    /**
     * 商品詳細ページに必要な情報がすべて表示される
     */
    public function test_item_detail_page_displays_all_required_information()
    {
        $user = User::factory()->create([
            'name' => 'ItemDetail',
            'email' => 'ItemDetail@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),  // テスト用にメール認証はスキップ
        ]);

        $categories = Category::take(3)->get();

        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'price' => 10000,
            'description' => 'テスト商品説明',
            'user_id' => $user->id,
        ]);

        $item->categories()->attach($categories->pluck('id')->toArray());

        $item->comments()->create([
            'user_id' => $user->id,
            'content' => 'テストコメント',
        ]);
        $item->likedByUsers()->attach($user->id);

        $response = $this->get(route('item.show', ['item_id' => $item->id]));

        $response->assertStatus(200);
        $response->assertSee($item->name);
        $response->assertSee($item->brand);
        $response->assertSee(number_format($item->price));
        $response->assertSee($item->description);
        $response->assertSee($categories->pluck('name')->toArray());
        $response->assertSee('テストコメント');
        $response->assertSee($user->name);
        $response->assertSee((string) $item->comments->count());
        $response->assertSee((string) $item->likedByUsers->count());
    }

    /**
     * 商品詳細ページで複数選択されたカテゴリが正しく表示される
     */
    public function test_item_detail_page_displays_multiple_categories()
    {
        $categories = Category::take(3)->get();
        $item = Item::factory()->create();
        $item->categories()->attach($categories->pluck('id')->toArray());

        $response = $this->get(route('item.show', ['item_id' => $item->id]));

        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
    }
}