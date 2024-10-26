<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('testpass'),
        ]);

        $categories = Category::all();
        $conditions = config('condition');

        $items = [
            [
                'name' => '腕時計',
                'brand' => 'Armani',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'items/watch.jpeg',
                'categories' => ['ファッション', 'メンズ', 'アクセサリー'],
                'condition' => $conditions['0'],
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'items/hdd.jpeg',
                'categories' => ['家電', 'ゲーム'],
                'condition' => $conditions['1'],
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'image_path' => 'items/onions.jpeg',
                'categories' => ['キッチン', 'ハンドメイド'],
                'condition' => $conditions['2'],
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'items/shoes.jpeg',
                'categories' => ['ファッション', 'メンズ'],
                'condition' => $conditions['3'],
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'image_path' => 'items/laptop.jpeg',
                'categories' => ['家電'],
                'condition' => $conditions['0'],
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'items/microphone.jpeg',
                'categories' => ['家電', 'ゲーム'],
                'condition' => $conditions['1'],
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'items/purse.jpeg',
                'categories' => ['ファッション', 'レディース'],
                'condition' => $conditions['2'],
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'image_path' => 'items/tumbler.jpeg',
                'categories' => ['スポーツ', 'キッチン'],
                'condition' => $conditions['3'],
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'image_path' => 'items/grinder.jpeg',
                'categories' => ['インテリア', 'キッチン', 'ハンドメイド'],
                'condition' =>  $conditions['0'],
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'image_path' => 'items/make-up.jpeg',
                'categories' => ['レディース', 'コスメ'],
                'condition' => $conditions['1'],
            ],
        ];

        foreach ($items as $item) {
            $itemId = DB::table('items')->insertGetId([
                'name' => $item['name'],
                'price' => $item['price'],
                'description' => $item['description'],
                'image_path' => $item['image_path'],
                'user_id' => $user->id,
                'condition' => $item['condition'],
            ]);

            // カテゴリとの関連付け
            foreach ($item['categories'] as $categoryName) {
                $category = $categories->firstWhere('name', $categoryName);
                if ($category) {
                    DB::table('category_item')->insert([
                        'item_id' => $itemId,
                        'category_id' => $category->id,
                    ]);
                }
            }
        }
    }
}