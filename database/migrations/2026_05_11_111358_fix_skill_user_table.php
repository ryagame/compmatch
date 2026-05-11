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
    // Menghapus tabel lama yang strukturnya berantakan
    Schema::dropIfExists('skill_user'); 
    
    // Membuat ulang tabel pivot dengan kolom yang diminta Laravel
    Schema::create('skill_user', function (Blueprint $table) {
        $table->id();
        // Kolom ini yang tadi hilang/error:
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('skill_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('skill_user');
}
};
