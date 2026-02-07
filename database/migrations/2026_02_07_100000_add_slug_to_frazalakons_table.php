<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frazalakons', function (Blueprint $table) {
            $table->string('slug')->unique()->after('id')->nullable();
        });

        // Populate slugs for existing rows
        $frazalakons = DB::table('frazalakons')->select('id', 'body')->get();
        $usedSlugs = [];

        foreach ($frazalakons as $frazalakon) {
            $base = Str::slug(Str::limit($frazalakon->body, 80, ''));

            if ($base === '') {
                $base = 'frazalakon';
            }

            $slug = $base;
            $counter = 1;

            while (in_array($slug, $usedSlugs, true)) {
                $slug = $base.'-'.$counter;
                $counter++;
            }

            $usedSlugs[] = $slug;

            DB::table('frazalakons')
                ->where('id', $frazalakon->id)
                ->update(['slug' => $slug]);
        }

        // Now make it non-nullable
        Schema::table('frazalakons', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('frazalakons', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
