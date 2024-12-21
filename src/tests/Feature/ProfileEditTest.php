<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $address = Address::create([
            'zip_code' => '123-4567',
            'address' => 'テスト市',
            'building' => 'テストハウス',
        ]);

        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'profile_image' => 'path/to/profile/image.jpg',
            'password' => bcrypt('password123'),
            'address_id' => $address->id,
        ]);
    }

    /**
     * 変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）
     */
    public function test_user_profile_displays_correct_initial_information()
    {
        // ユーザーにログインする
        $this->actingAs($this->user);

        // プロフィールページを開く
        $response = $this->get(route('profile.edit', ['user' => $this->user->id]));

        // プロフィール画像の初期値が正しく表示されることを確認
        $response->assertSee($this->user->profile_image);

        // ユーザー名の初期値が正しく表示されることを確認
        $response->assertSee($this->user->name);

        // 郵便番号の初期値が正しく表示されることを確認
        $response->assertSee($this->user->address->zip_code);

        // 住所の初期値が正しく表示されることを確認
        $response->assertSee($this->user->address->address);

        // 建物名の初期値が正しく表示されることを確認
        $response->assertSee($this->user->address->building);
    }
}