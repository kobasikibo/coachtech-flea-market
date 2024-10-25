<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'testpass',
        ]);

        $categories = Category::all();
        $conditions = config('condition');

        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'categories' => json_encode(['ファッション', 'メンズ', 'アクセサリー']),
                'condition' => $conditions['良好'],
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'description' => '高速で信頼性の高いハードディスク',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'categories' => json_encode(['家電', 'ゲーム']),
                'condition' => $conditions['目立った傷や汚れなし'],
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'description' => '新鮮な玉ねぎ3束のセット',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'categories' => json_encode(['キッチン', 'ハンドメイド']),
                'condition' => $conditions['やや傷や汚れあり'],
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'description' => 'クラシックなデザインの革靴',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'categories' => json_encode(['ファッション', 'メンズ']),
                'condition' => $conditions['状態が悪い'],
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'description' => '高性能なノートパソコン',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'categories' => json_encode(['家電']),
                'condition' => $conditions['良好'],
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'description' => '高音質のレコーディング用マイク',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'categories' => json_encode(['家電', 'ゲーム']),
                'condition' => $conditions['目立った傷や汚れなし'],
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'description' => 'おしゃれなショルダーバッグ',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'categories' => json_encode(['ファッション', 'レディース']),
                'condition' => $conditions['やや傷や汚れあり'],
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'description' => '使いやすいタンブラー',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'categories' => json_encode(['スポーツ', 'キッチン']),
                'condition' => $conditions['状態が悪い'],
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'description' => '手動のコーヒーミル',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'categories' => json_encode(['インテリア', 'キッチン', 'ハンドメイド']),
                'condition' =>  $conditions['良好'],
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'description' => '便利なメイクアップセット',
                'image_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'categories' => json_encode(['レディース', 'コスメ']),
                'condition' => $conditions['目立った傷や汚れなし'],
            ],
        ];

        foreach ($items as $item) {
            // アイテムをデータベースに挿入
            $itemId = DB::table('items')->insertGetId([
                'name' => $item['name'],
                'price' => $item['price'],
                'description' => $item['description'],
                'image_path' => $item['image_path'],
                'user_id' => $user->id,
                'condition' => $item['condition'], // conditionを挿入
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