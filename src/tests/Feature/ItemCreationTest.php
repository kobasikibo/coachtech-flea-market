<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ItemCreationTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
        $this->user = User::factory()->create([
            'name' => 'ItemCreation',
            'email' => 'itemcreation@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
    }

    /**
     * 商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、商品の説明、販売価格）
     */
    public function test_item_creation_saves_correct_information()
    {
        Storage::fake('public');

        $categories = Category::take(3)->pluck('id')->toArray();

        // ユーザーにログイン
        $this->actingAs($this->user);

        // 商品出品画面を開く
        $response = $this->get(route('item.create'));
        $response->assertStatus(200);

        $image = UploadedFile::fake()->create('test_image.jpg', 100, 'image/jpeg');

        // 各項目に適切な情報を入力して保存
        $response = $this->post(route('item.store'), [
            'name' => 'Test Item',
            'description' => 'This is a test item description.',
            'image' => $image,
            'category_ids' => $categories,
            'condition' => config('condition')[0],
            'price' => 1000,
        ]);

        // 各項目が正しく保存されている
            $this->assertDatabaseHas('items', [
            'name' => 'Test Item',
            'description' => 'This is a test item description.',
            'condition' => config('condition')[0],
            'price' => 1000,
        ]);

        $item = Item::where('name', 'Test Item')->first();

        foreach ($categories as $categoryId) {
            $this->assertDatabaseHas('category_item', [
                'item_id' => $item->id,
                'category_id' => $categoryId,
            ]);
        }

        $this->assertTrue(\Storage::disk('public')->exists("items/{$image->hashName()}"));
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(storage_path('framework/testing'));

        parent::tearDown();
    }
}