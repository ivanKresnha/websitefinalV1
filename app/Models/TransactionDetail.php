<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TransactionDetail extends Model
{
    use HasFactory;

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Relasi ke Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    protected $fillable = [
        'transaction_id',
        'product_id', // Tambahkan ini
        'jmlh_pesan',
        'total_harga_produk',
        // atribut lain yang sudah ada
    ];
}








// class TransactionDetail extends Model
// {
//     use HasFactory;

//     // Relasi ke Product
//     public function product()
//     {
//         return $this->belongsTo(Product::class, 'product_id', 'id');
//     }

//     // Relasi ke Transaction
//     public function transaction()
//     {
//         return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
//     }

//     protected $fillable = [
//         return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
//         // 'transaction_id',
//         // atribut lain yang sudah ada
//     ];
// }

