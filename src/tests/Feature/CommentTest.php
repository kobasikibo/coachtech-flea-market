<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン済みのユーザーはコメントを送信できる
     */
    public function test_authenticated_user_can_send_comment()
    {
        $user = User::factory()->create([
            'name' => 'Comment',
            'email' => 'comment@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $item = Item::factory()->create();

        $initialCommentCount = $item->comments()->count();

        $commentContent = 'テストコメント';

        // ユーザーにログインする
        $this->actingAs($user);

        $response = $this->post(route('comments.store', ['item_id' => $item->id]), [
            'content' => $commentContent,
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => $commentContent,
        ]);

        $response = $this->get(route('item.show', ['item_id' => $item->id]));
        $this->assertDatabaseCount('comments', $initialCommentCount + 1);
        $this->get(route('item.show', ['item_id' => $item->id]))
            ->assertSee($commentContent);
    }

    /**
     * ログイン前のユーザーはコメントを送信できない
     */
    public function test_guest_user_cannot_send_comment()
    {
        $user = User::factory()->create([
            'name' => 'Comment',
            'email' => 'comment@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $item = Item::factory()->create();

        $commentContent = 'テストコメント';

        $response = $this->post(route('comments.store', ['item_id' => $item->id]), [
            'content' => $commentContent,
        ]);

        $response->assertRedirect(route('login'));
    }

    /**
     * コメントが入力されていない場合、バリデーションメッセージが表示される
     */
    public function test_validation_message_is_displayed_when_comment_is_empty()
    {
        $user = User::factory()->create([
            'name' => 'Comment',
            'email' => 'comment@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('comments.store', ['item_id' => $item->id]), [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    /**
     * コメントが255字以上の場合、バリデーションメッセージが表示される
     */
    public function test_validation_message_is_displayed_when_comment_is_too_long()
    {
        $user = User::factory()->create([
            'name' => 'Comment',
            'email' => 'comment@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $item = Item::factory()->create();

        $this->actingAs($user);

        $longComment = str_repeat('a', 256);

        $response = $this->post(route('comments.store', ['item_id' => $item->id]), [
            'content' => $longComment,
        ]);

        $response->assertSessionHasErrors('content');
    }
}
