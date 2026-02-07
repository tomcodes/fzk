<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frazalakon_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('frazalakon_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'frazalakon_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frazalakon_likes');
    }
};
