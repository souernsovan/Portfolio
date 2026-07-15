<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('name')
                ->constrained('skill_categories')->nullOnDelete();
        });

        $distinctCategories = DB::table('skills')
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        foreach ($distinctCategories as $index => $name) {
            $categoryId = DB::table('skill_categories')->insertGetId([
                'name' => $name,
                'sort_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('skills')->where('category', $name)->update(['category_id' => $categoryId]);
        }

        Schema::table('skills', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->string('category')->nullable()->after('name');
        });

        DB::table('skills')->update([
            'category' => DB::raw('(select name from skill_categories where skill_categories.id = skills.category_id)'),
        ]);

        Schema::table('skills', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
