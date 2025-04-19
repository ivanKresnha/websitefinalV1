<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_harga_kirim', 'total_bayar', 'kembalian', 'alamat', 'catatan_tambahan', 'metode_bayar', 'gambar_bukti_bayar', 'status_transaksi', 'status_pengiriman', 'tgl_transaksi'
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_id', 'id');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    // Relasi ke Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
