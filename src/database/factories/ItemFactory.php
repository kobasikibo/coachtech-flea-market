<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition(): array
    {
        $conditions = config('condition');
        $user = User::first();

        return [
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(1000, 50000),
            'description' => $this->faker->sentence,
            'image_path' => 'items/' . $this->faker->md5 . '.png', // ダミー画像パスを生成
            'condition' => $this->faker->randomElement($conditions),
            'user_id' => $user->id,
        ];
    }
}
