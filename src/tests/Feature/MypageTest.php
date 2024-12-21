<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
            'profile_image' => 'path/to/profile/image.jpg',
        ]);

        $this->item = Item::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Sample Item',
        ]);

        $purchase = Purchase::factory()->create([
            'user_id' => $this->user->id,
            'item_id' => $this->item->id,
        ]);
    }

    /**
     * 必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
     */
    public function test_user_profile_displays_correct_information()
    {
        // ユーザーにログインする
        $this->actingAs($this->user);

        // プロフィールページを開く
        $response = $this->get(route('mypage.show', ['user' => $this->user->id]));

        // プロフィール画像が正しく表示されることを確認
        $response->assertSee($this->user->profile_image);

        // ユーザー名が正しく表示されることを確認
        $response->assertSee($this->user->name);

        // 出品した商品が正しく表示されることを確認
        $response->assertSee($this->item->name);

        // 購入した商品が正しく表示されることを確認
        $response->assertSee($this->item->name);
    }
}
