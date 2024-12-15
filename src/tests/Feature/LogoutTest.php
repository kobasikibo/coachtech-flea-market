<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログアウトができる
     */
    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'name' => 'logoutUser',
            'email' => 'logoutUser@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(), // テスト用にメール認証はスキップ
            'is_first_login' => false, // テスト用に初回ログイン時ユーザー設定をキャンセル
        ]);

        $response = $this->post('/login', [
            'email' => 'logoutUser@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');

        $response = $this->post('/logout');

        $response->assertRedirect('/');

        $this->assertGuest();
    }
}