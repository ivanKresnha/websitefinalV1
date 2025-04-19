<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Category; // Import model Category

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained()->onDelete('cascade'); // Relasi dengan tabel categories
            $table->string('nama'); // Nama produk
            $table->integer('harga'); // Harga produk
            $table->integer('stok'); // Jumlah stok produk
            $table->string('deskripsi'); // Deskripsi  produk
            $table->string('gambar_produk')->nullable(); // Nama file gambar produk
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
