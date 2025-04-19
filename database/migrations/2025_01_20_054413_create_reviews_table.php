<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel users
            $table->foreignId('transaction_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel transaksi
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Menghubungkan ke tabel produk
            $table->integer('rating')->nullable(); // Rating produk (1-5)
            $table->text('ulasan')->nullable(); // Komentar atau ulasan
            $table->string('gambar_ulasan')->nullable(); // Menyimpan path gambar ulasan
            $table->enum('status_ulasan', ['Sudah Divalidasi', 'Belum Divalidasi'])->default('belum divalidasi'); // Status validasi
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
