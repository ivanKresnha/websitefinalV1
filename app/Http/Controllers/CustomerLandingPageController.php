<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CustomerLandingPageController extends Controller
{
    public function index()
    {
        // Ambil kategori dengan produk dan ulasan yang sudah divalidasi
        $categories = Category::with([
            'products' => function ($query) {
                $query->with([
                    'reviews' => function ($query) {
                        $query->where('status_ulasan', 'Sudah Divalidasi')->with('user');
                    }
                ]);
            }
        ])->get();

        // Ambil produk dengan ID tertentu dan ulasan yang sudah divalidasi
        $productId = 3; // ID produk yang ingin ditampilkan
        $product = Product::with([
            'reviews' => function ($query) {
                $query->where('status_ulasan', 'Sudah Divalidasi')->with('user');
            }
        ])->find($productId);

        // Cek jika produk tidak ditemukan
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Ambil produk terlaris dengan ulasan yang sudah divalidasi
        $produkTerbaik = Product::with([
            'reviews' => function ($query) {
                $query->where('status_ulasan', 'Sudah Divalidasi')->with('user');
            }
        ])
            ->selectRaw('
                products.id,
                products.nama,
                products.harga,
                products.stok,
                products.gambar_produk,
                products.category_id,
                SUM(transaction_details.jmlh_pesan) as total_sold
            ')
            ->join('transaction_details', 'products.id', '=', 'transaction_details.product_id')
            ->groupBy('products.id', 'products.nama', 'products.harga', 'products.stok', 'products.gambar_produk', 'products.category_id')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

        // Kirim data ke view
        return view('dashboard.landingpage.index', compact('categories', 'produkTerbaik', 'product'));
    }
}
