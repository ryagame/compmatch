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
    Schema::table('skills', function (Blueprint $table) {
        // Cek dulu apakah kolom sudah ada sebelum menambah, agar tidak error
        if (!Schema::hasColumn('skills', 'name')) {
            $table->string('name')->after('id');
        }
        if (!Schema::hasColumn('skills', 'slug')) {
            $table->string('slug')->after('name');
        }
    });
}

public function down(): void
{
    Schema::table('skills', function (Blueprint $table) {
        $table->dropColumn(['name', 'slug']);
    });
}
};
