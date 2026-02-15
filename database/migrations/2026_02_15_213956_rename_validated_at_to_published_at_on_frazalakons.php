<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frazalakons', function (Blueprint $table) {
            $table->renameColumn('validated_at', 'published_at');
        });
    }

    public function down(): void
    {
        Schema::table('frazalakons', function (Blueprint $table) {
            $table->renameColumn('published_at', 'validated_at');
        });
    }
};
