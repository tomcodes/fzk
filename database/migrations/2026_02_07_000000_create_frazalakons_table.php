<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frazalakons', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('group_id')->nullable();
            $table->text('body');
            $table->text('who');
            $table->text('towho')->nullable();
            $table->text('context')->nullable();
            $table->text('where')->nullable();
            $table->timestamp('when')->useCurrent();
            $table->text('author')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->boolean('public')->default(false);
            $table->integer('heart_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frazalakons');
    }
};
