<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * SRS-06: Kolaborasi List
     * Pivot table untuk relasi Many-to-Many antara users dan lists.
     * Menyimpan data member (bukan owner) yang dapat mengakses suatu list.
     */
    public function up(): void
    {
        Schema::create('list_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')->constrained('lists')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            // Pastikan satu user hanya bisa ditambahkan satu kali ke list yang sama
            $table->unique(['list_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('list_user');
    }
};
