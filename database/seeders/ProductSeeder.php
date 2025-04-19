<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category; // Pastikan untuk mengimport Category

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Mendapatkan kategori yang sudah ada
        $category1 = Category::where('nama', 'Sosis')->first(); // Menemukan kategori berdasarkan nama
        $category2 = Category::where('nama', 'Kentang')->first(); // Menemukan kategori berdasarkan nama

        // Menambahkan produk setelah kategori ditemukan
        Product::insert([
            [
                'nama' => 'Produk 1',
                'harga' => 50000,
                'stok' => 100,
                'gambar_produk' => 'product1.jpg',
                'category_id' => $category1->id,
                'deskripsi' => 'Deskripsi untuk produk 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Produk 2',
                'harga' => 75000,
                'stok' => 50,
                'gambar_produk' => 'product2.jpg',
                'category_id' => $category2->id,
                'deskripsi' => 'Deskripsi untuk produk 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Produk 3',
                'harga' => 120000,
                'stok' => 30,
                'gambar_produk' => 'product3.jpg',
                'category_id' => $category1->id,
                'deskripsi' => 'Deskripsi untuk produk 3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}
