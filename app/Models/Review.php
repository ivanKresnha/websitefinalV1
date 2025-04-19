<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        // Menyimpan ID pengguna
        'transaction_id',
        // Menyimpan ID transaksi
        'product_id',
        // Menyimpan ID produk
        'rating',
        // Menyimpan rating (1-5)
        'ulasan',
        // Menyimpan teks ulasan
        'status_ulasan',
        // Menyimpan path gambar ulasan
        'gambar_ulasan', // Menyimpan path gambar ulasan
    ];


    // Menentukan nilai enum untuk status_ulasan
    protected $casts = [
        'status_ulasan' => 'string',
    ];

    const STATUS_VALIDATED = 'Sudah Divalidasi';
    const STATUS_NOT_VALIDATED = 'Belum Divalidasi';

    const MIN_RATING = 1;
    const MAX_RATING = 5;



// Relasi dengan produk (satu produk memiliki banyak ulasan)
public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'id');
}

// Relasi dengan transaksi (satu transaksi mungkin memiliki ulasan terkait)
public function transaction()
{
    return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
}

// Relasi dengan user (satu pengguna memberikan ulasan)
public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id');
}

protected static function boot()
{
    parent::boot();

    static::saving(function ($review) {
        if ($review->rating < self::MIN_RATING || $review->rating > self::MAX_RATING) {
            throw new \InvalidArgumentException('Rating harus berada di antara ' . self::MIN_RATING . ' dan ' . self::MAX_RATING);
        }
    });
}

public function scopeValidated($query)
{
    return $query->where('status_ulasan', self::STATUS_VALIDATED);
}

public function scopeNotValidated($query)
{
    return $query->where('status_ulasan', self::STATUS_NOT_VALIDATED);
}


}