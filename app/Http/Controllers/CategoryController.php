<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ActivityLog;  // Pastikan model ActivityLog sudah dibuat

use Illuminate\Http\Request;

class CategoryController extends Controller
{ 

    // Menampilkan daftar kategori
    public function index()
    {
        $categories = Category::all(); // Ambil semua kategori dari database
        return view('dashboard.admin.kategori.index', compact('categories')); // Menampilkan view kategori.index
    }

    // Menampilkan form untuk menambah kategori
    public function create()
    {
        return view('dashboard.admin.kategori.create'); // Menampilkan view kategori.create
    }

    // Menyimpan kategori baru ke dalam database
    public function store(Request $request)
{
    // Validasi inputan nama kategori
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
    ]);

    // Membuat kategori baru
    $category = Category::create($validated);

    // Menambahkan log aktivitas setelah menambah kategori
    ActivityLog::create([
        'user_id' => auth()->id(),
        'tabel_referensi' => 'categories',
        'id_referensi' => $category->id,
        'deskripsi' => 'Kategori ditambahkan: ' . $category->nama,
    ]);

    return redirect()->route('dashboard.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
}


    // Menampilkan form untuk mengedit kategori
    public function edit(Category $category)
    {
        return view('dashboard.admin.kategori.edit', compact('category')); // Menampilkan view kategori.edit
    }

    // Memperbarui data kategori di database
    public function update(Request $request, Category $category)
    {
        // Validasi inputan nama kategori
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
    
        // Memperbarui kategori
        $category->update($validated);
    
        // Menambahkan log aktivitas setelah memperbarui kategori
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'categories',
            'id_referensi' => $category->id,
            'deskripsi' => 'Kategori diperbarui: ' . $category->nama,
        ]);
    
        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }
    

    // Menghapus kategori dari database
    public function destroy(Category $category)
    {
        // Cek apakah kategori terkait dengan produk
        if ($category->products()->exists()) {
            // Jika ada produk yang terkait, tampilkan pesan error
            return redirect()->route('dashboard.categories.index')->with('error', 'Kategori tidak dapat dihapus karena ada produk yang terkait.');
        }
    
        // Menambahkan log aktivitas sebelum menghapus kategori
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'categories',
            'id_referensi' => $category->id,
            'deskripsi' => 'Kategori dihapus: ' . $category->nama,
        ]);
    
        // Menghapus kategori
        $category->delete();
    
        return redirect()->route('dashboard.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
    
    
}
