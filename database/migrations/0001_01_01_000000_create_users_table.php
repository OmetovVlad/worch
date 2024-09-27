<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('telegram')->nullable();
            $table->string('password')->nullable();
			$table->string('img_path')->nullable();
			$table->string('firstname')->nullable();
			$table->string('surname')->nullable();
			$table->string('nickname')->nullable();
			$table->string('language')->nullable();
			$table->string('role')->nullable();
			$table->string('name')->nullable();
			$table->boolean('is_premium')->default(false);
			$table->unsignedBigInteger('balance')->default(0);
			$table->unsignedBigInteger('price')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
