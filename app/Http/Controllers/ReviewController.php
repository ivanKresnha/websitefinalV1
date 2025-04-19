<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Review;
use App\Models\ActivityLog; // Import model ActivityLog
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function getProducts($transactionId)
{
    // Cari transaksi berdasarkan ID dan pastikan transaksi ini terkait dengan pengguna yang login, 
    // atau jika pengguna adalah admin, biarkan dia melihat semua transaksi
    $transaction = Transaction::with('details.product')->find($transactionId);

    // Jika transaksi tidak ditemukan atau detailnya kosong
    if (!$transaction || $transaction->details->isEmpty()) {
        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }

    // Jika pengguna bukan admin, pastikan transaksi tersebut milik pengguna yang login
    if (auth()->user()->role_id != 1 && $transaction->user_id != auth()->id()) {
        return response()->json(['message' => 'Akses tidak diizinkan'], 403); // Mengembalikan akses ditolak jika bukan milik pengguna
    }

    // Ambil detail transaksi beserta produk terkait
    $products = $transaction->details->map(function ($detail) {
        return [
            'id' => $detail->product->id,
            'nama' => $detail->product->nama,
            'image' => asset('storage/uploads/produk/' . $detail->product->gambar_produk),
        ];
    });

    // Kembalikan data produk dalam format JSON
    return response()->json($products);
}


    // Menampilkan daftar ulasan produk
    public function index()
    {
        $user = auth()->user(); // Get the logged-in user

        if ($user->role->name == 'administrator') {
            // Jika pengguna adalah administrator, tampilkan semua ulasan
            $reviews = Review::with('product', 'transaction.user')->get();
        } else {
            // Jika pengguna bukan administrator, tampilkan hanya ulasan milik pengguna
            $reviews = Review::with('product', 'transaction.user')
                ->where('user_id', $user->id) // Filter ulasan berdasarkan user_id
                ->get();
        }

        return view('dashboard.admin.reviews.index', compact('reviews'));
    }

    // Menampilkan detail ulasan tertentu
    public function show(Review $review)
    {
        // Periksa apakah pengguna yang login adalah pemilik ulasan
        if ($review->user_id !== auth()->id() && auth()->user()->role_id !== 1) {
            abort(403, 'Akses tidak diizinkan.');
        }

        return view('dashboard.admin.reviews.show', compact('review'));
    }

    // Menampilkan form untuk menambahkan ulasan
    public function create()
    {
        $user = auth()->user(); // Get the logged-in user
        
        // If the user is not an admin, only show their own transactions
        if ($user->role_id != 1) {
            $transactions = $user->transactions; // Get the logged-in user's transactions
        } else {
            $transactions = Transaction::with('user', 'details.product')->get(); // Get all transactions for admin
        }
        
        // Ensure $transactions is an array if it's null or empty
        $transactions = $transactions ?? [];
        
        return view('dashboard.admin.reviews.create', compact('transactions'));
    }
    

    // Menyimpan ulasan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:500',
            'gambar_ulasan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_ulasan' => 'required|in:Sudah Divalidasi,Belum Divalidasi',
        ]);
    
        /// Proses upload gambar ulasan
$gambarPath = null;
if ($request->hasFile('gambar_ulasan')) {
    $gambarPath = $this->uploadFile($request->file('gambar_ulasan'), 'uploads/ulasan'); // Nama file saja
}
    
        // Jika pengguna bukan admin, set status ulasan menjadi 'Belum Divalidasi'
        $statusUlasan = auth()->user()->role_id == 1 ? $validated['status_ulasan'] : 'Belum Divalidasi';
    
        // Menyimpan review
        $review = Review::create([
            'user_id' => auth()->id(),
            'transaction_id' => $validated['transaction_id'],
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'ulasan' => $validated['ulasan'],
            'gambar_ulasan' => $gambarPath,
            'status_ulasan' => $statusUlasan, // Status otomatis 'Belum Divalidasi' jika bukan admin
        ]);
    
        // Log aktivitas: Menambahkan ulasan
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'reviews',
            'id_referensi' => $review->id,
            'deskripsi' => 'Menambahkan ulasan untuk produk #' . $validated['product_id'],
        ]);
    
        return redirect()->route('dashboard.reviews.index')->with('success', 'Ulasan berhasil ditambahkan.');
    }
    

    // Menampilkan form untuk mengedit ulasan
    public function edit(Review $review)
    {
        // Pastikan pengguna hanya bisa mengedit ulasan miliknya sendiri
        if ($review->user_id !== auth()->id() && auth()->user()->role_id !== 1) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $products = Product::all(); // Semua produk
        $transactions = Transaction::all(); // Semua transaksi

        return view('dashboard.admin.reviews.edit', compact('review', 'products', 'transactions'));
    }

    // Menyimpan perubahan ulasan
    public function update(Request $request, Review $review)
    {
       if ($request->hasFile('gambar_ulasan')) {
    // Hapus file lama jika ada
    if ($review->gambar_ulasan && Storage::exists('uploads/ulasan/' . $review->gambar_ulasan)) {
        Storage::delete('uploads/ulasan/' . $review->gambar_ulasan);
    }

    // Simpan file baru dan ambil nama file
    $gambarPath = $this->uploadFile($request->file('gambar_ulasan'), 'uploads/ulasan');
    $review->gambar_ulasan = $gambarPath; // Nama file saja
}
    
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:500',
            'gambar_ulasan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_ulasan' => 'required|in:Sudah Divalidasi,Belum Divalidasi',
        ]);
    
        // Proses upload gambar baru jika ada
        if ($request->hasFile('gambar_ulasan')) {
            if ($review->gambar_ulasan && Storage::exists('public/' . $review->gambar_ulasan)) {
                Storage::delete('public/' . $review->gambar_ulasan);
            }
            $gambarPath = $this->uploadFile($request->file('gambar_ulasan'), 'uploads/ulasan');
            $review->gambar_ulasan = $gambarPath;
        }
    
        // Pastikan status ulasan sesuai dengan role
        if (auth()->user()->role_id != 1) {
            $review->status_ulasan = 'Belum Divalidasi'; // Jika bukan admin
        } else {
            $review->status_ulasan = $validated['status_ulasan']; // Admin bisa memilih status
        }
    
        $review->update([
            'rating' => $validated['rating'],
            'ulasan' => $validated['ulasan'],
            'status_ulasan' => $review->status_ulasan,
            'gambar_ulasan' => $review->gambar_ulasan,
        ]);
    
        // Log aktivitas: Memperbarui ulasan
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'reviews',
            'id_referensi' => $review->id,
            'deskripsi' => 'Memperbarui ulasan untuk produk #' . $review->product_id,
        ]);
    
        return redirect()->route('dashboard.reviews.index')->with('success', 'Ulasan berhasil diperbarui.');
    }
    
    // Menghapus ulasan produk
    public function destroy(Review $review)
    {
        // Pastikan pengguna hanya bisa menghapus ulasan miliknya sendiri
        if ($review->user_id !== auth()->id() && auth()->user()->role_id !== 1) {
            abort(403, 'Akses tidak diizinkan.');
        }
    
        if ($review->gambar_ulasan && Storage::exists('public/' . $review->gambar_ulasan)) {
            Storage::delete('public/' . $review->gambar_ulasan);
        }
    
        $review->delete();
    
        // Log aktivitas: Menghapus ulasan
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'reviews',
            'id_referensi' => $review->id,
            'deskripsi' => 'Menghapus ulasan untuk produk #' . $review->product_id,
        ]);
    
        return redirect()->route('dashboard.reviews.index')->with('success', 'Ulasan berhasil dihapus.');
    }
    
    // Fungsi untuk upload file dengan nama asli
    private function uploadFile($file, $path)
    {
        // Dapatkan nama file asli
        $originalName = $file->getClientOriginalName();
    
        // Periksa jika file dengan nama yang sama sudah ada di folder
        if (Storage::exists('public/' . $path . '/' . $originalName)) {
            $timestamp = time();
            $originalName = pathinfo($originalName, PATHINFO_FILENAME) . "_" . $timestamp . "." . $file->getClientOriginalExtension();
        }
    
        // Simpan file ke folder tanpa mengembalikan path lengkap
        $file->storeAs('public/' . $path, $originalName);
    
        // Hanya kembalikan nama file tanpa folder
        return $originalName;
    }
    
}
