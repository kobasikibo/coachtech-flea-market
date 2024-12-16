<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     *  名前が入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_name_is_required()
    {
        // 名前を入力せずに他の必要項目を入力する
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // 「お名前を入力してください」というバリデーションメッセージが表示される
        $response->assertSessionHasErrors(['name' => 'お名前を入力してください']);
    }

    /**
     * メールアドレスが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_email_is_required()
    {
        // メールアドレスを入力せずに他の必要項目を入力する
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // 「メールアドレスを入力してください」というバリデーションメッセージが表示される
        $response->assertSessionHasErrors(['email' => 'メールアドレスを入力してください']);
    }

    /**
     * パスワードが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_password_is_required()
    {
        // パスワードを入力せずに他の必要項目を入力する
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);

        // 「パスワードを入力してください」というバリデーションメッセージが表示される
        $response->assertSessionHasErrors(['password' => 'パスワードを入力してください']);
    }

    /**
     * パスワードが7文字以下の場合、バリデーションメッセージが表示される
     */
    public function test_password_min_length()
    {
        // 7文字以下のパスワードと他の必要項目を入力する
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        // 「パスワードは8文字以上で入力してください」というバリデーションメッセージが表示される
        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    /**
     * パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される
     */
    public function test_password_confirmation_must_match()
    {
        // 確認用パスワードと異なるパスワードを入力し、他の必要項目も入力する
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        // 「パスワードと一致しません」というバリデーションメッセージが表示される
        $response->assertSessionHasErrors(['password_confirmation' => 'パスワードと一致しません']);
    }

    /**
     * 全ての項目が入力されている場合、会員情報が登録され、ログイン画面に遷移される
     */
    public function test_registration_successful()
    {
        // 全ての必要項目を正しく入力する
        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // 会員情報が登録され、ログイン画面に遷移する
        $response->assertRedirect(route('login'));

        $this->assertDatabaseHas('users', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
        ]);
    }
}
