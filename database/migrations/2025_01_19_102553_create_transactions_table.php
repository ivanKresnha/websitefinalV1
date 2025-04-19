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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users
            $table->integer('total_harga_kirim'); // Total harga biaya pengiriman
            $table->integer('total_bayar'); // Total bayar dari pembeli
            $table->integer('kembalian'); // Kembalian
            $table->text('alamat'); // Alamat pengiriman
            $table->text('catatan_tambahan')->nullable(); // Catatan tambahan
            $table->enum('metode_bayar', ['BCA', 'MANDIRI'])->default('BCA'); // Menambahkan enum
            $table->string('gambar_bukti_bayar')->nullable(); // Bukti bayar
            $table->enum('status_transaksi', ['Sudah Diproses', 'Belum Diproses'])->default('Belum Diproses'); // Status transaksi
            $table->enum('status_pengiriman', ['Sudah Dikirim', 'Belum Dikirim'])->default('Belum Dikirim'); // Status pengiriman
            $table->date('tgl_transaksi'); // Tanggal transaksi
            $table->timestamps(); // Timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
