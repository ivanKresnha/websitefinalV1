<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'nama', 'harga', 'stok', 'deskripsi', 'gambar_produk'
    ];

    // Relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Relasi ke reviews
    public function reviews() 
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }
    // Relasi dengan TransactionDetail
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }


    // Mengambil total jumlah produk yang dibeli
    public function totalQuantitySold()
    {
        return $this->transactionDetails()->sum('jmlh_pesan');
    }
}
