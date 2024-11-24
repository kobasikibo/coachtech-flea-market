<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('condition')->notNullable();
            $table->string('name')->notNullable();
            $table->string('brand')->nullable();
            $table->decimal('price', 10, 2)->notNullable();
            $table->text('description')->notNullable();
            $table->string('image_path')->notNullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
        });

        Schema::dropIfExists('items');
    }
};
