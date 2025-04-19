<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ActivityLog; // Import model ActivityLog
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();

        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'products',
            'id_referensi' => null, // Tidak ada ID produk terkait
            'deskripsi' => 'Melihat daftar produk',
        ]);

        return view('dashboard.admin.produk.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();

        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'products',
            'id_referensi' => null, // Tidak ada ID produk terkait
            'deskripsi' => 'Melihat form tambah produk',
        ]);

        return view('dashboard.admin.produk.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string|max:255', // Validasi deskripsi
        ]);

        // Handle file upload
        $filePath = null;
        if ($request->hasFile('gambar_produk')) {
            // Mendapatkan file asli
            $file = $request->file('gambar_produk');

            // Mendapatkan nama file asli tanpa perubahan
            $originalFileName = $file->getClientOriginalName();

            // Menyimpan file di folder public/uploads/produk dengan nama asli
            $file->storeAs('uploads/produk', $originalFileName, 'public');

            // Menyimpan hanya nama file di database (tanpa path)
            $filePath = $originalFileName;
        }

        // Menambahkan produk baru
        $product = Product::create([
            'category_id' => $validated['category_id'],
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok'],
            'gambar_produk' => $filePath ?? null,
            'deskripsi' => $validated['deskripsi'], // Simpan deskripsi
        ]);

        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'products',
            'id_referensi' => $product->id, // ID produk yang baru saja dibuat
            'deskripsi' => 'Menambahkan produk: ' . $product->nama,
        ]);

        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $categories = Category::all();

        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'products',
            'id_referensi' => $product->id, // ID produk yang dilihat
            'deskripsi' => 'Melihat produk: ' . $product->nama,
        ]);

        return view('dashboard.admin.produk.show', compact('product', 'categories'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'products',
            'id_referensi' => $product->id, // ID produk yang sedang diedit
            'deskripsi' => 'Melihat form edit produk: ' . $product->nama,
        ]);

        return view('dashboard.admin.produk.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi input
        $validated = $request->validate([
            'category_id' => 'nullable|exists:categories,id', // Validasi kategori
            'nama' => 'nullable|string|max:255',
            'harga' => 'nullable|numeric|min:0',
            'stok' => 'nullable|integer|min:0',
            'gambar_produk' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        // Handle file upload
        if ($request->hasFile('gambar_produk')) {
            // Hapus gambar lama jika ada
            if ($product->gambar_produk && Storage::exists('public/uploads/produk/' . $product->gambar_produk)) {
                Storage::delete('public/uploads/produk/' . $product->gambar_produk);
            }

            // Mendapatkan nama file asli tanpa path
            $originalFileName = $request->file('gambar_produk')->getClientOriginalName();

            // Menyimpan file dengan nama asli di folder uploads/produk
            $filePath = $request->file('gambar_produk')->storeAs('uploads/produk', $originalFileName, 'public');

            // Menyimpan hanya nama file di database (tanpa path)
            $validated['gambar_produk'] = $originalFileName;
        }

        // Update kategori produk jika ada perubahan
        if (isset($validated['category_id'])) {
            $product->category_id = $validated['category_id'];
        }

        // Update produk dengan data yang telah tervalidasi
        $product->update($validated);

        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'products',
            'id_referensi' => $product->id, // ID produk yang diperbarui
            'deskripsi' => 'Memperbarui produk: ' . $product->nama,
        ]);

        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Cek apakah produk terkait dengan data di tabel transaction_details
        if ($product->transactionDetails()->exists()) { // Asumsikan relasi transactionDetails sudah didefinisikan di model Product
            return redirect()->route('dashboard.products.index')->with('error', 'Produk tidak dapat dihapus karena memiliki transaksi terkait.');
        }

        // Hapus gambar produk jika ada
        if ($product->gambar_produk && Storage::exists('public/' . $product->gambar_produk)) {
            Storage::delete('public/' . $product->gambar_produk);
        }

        // Hapus produk
        $product->delete();

        // Log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'products',
            'id_referensi' => $product->id, // ID produk yang dihapus
            'deskripsi' => 'Menghapus produk: ' . $product->nama,
        ]);

        return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
