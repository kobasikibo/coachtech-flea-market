<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->onDelete('cascade');
            $table->string('name')->notNullable();
            $table->string('email')->unique()->notNullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->notNullable();
            $table->string('profile_image')->nullable();
            $table->boolean('is_first_login')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
