<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;


use Barryvdh\DomPDF\Facade\Pdf; // Tambahkan ini jika menggunakan dompdf untuk PDF

use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
{
    $user = Auth::user(); // Ambil data pengguna yang sedang login

    if ($user->role->name == 'administrator') {
        // Jika role adalah 'administrator', ambil semua transaksi
        $transactions = Transaction::with(['details.product', 'user'])->get();
    } else {
        // Jika bukan administrator, hanya ambil transaksi yang terkait dengan pengguna yang login
        $transactions = Transaction::with(['details.product', 'user'])
            ->where('user_id', $user->id)
            ->get();
    }

    return view('dashboard.admin.transaksi.index', compact('transactions'));
}



    public function create()
    {
        // Mengambil semua produk dan filter user berdasarkan role_id != 1
        $products = Product::all();
        $users = User::where('role_id', '!=', 1)->get(); // Filter users dengan role_id != 1
        return view('dashboard.admin.transaksi.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'cartData' => 'required|json',
            'total_bayar' => 'required|integer|min:0',
            'alamat' => 'required|string',
            'metode_bayar' => 'required|string',
            'catatan_tambahan' => 'nullable|string|max:500',
            'gambar_bukti_bayar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status_transaksi' => 'required|in:Sudah Diproses,Belum Diproses',
            'status_pengiriman' => 'required|in:Sudah Dikirim,Belum Dikirim',
            'tgl_transaksi' => 'required|date',
        ]);

        // Decode dan validasi cartData
        $cartItems = json_decode($validated['cartData'], true);

        if (empty($cartItems) || !is_array($cartItems)) {
            return redirect()->back()->withErrors(['cartData' => 'Keranjang tidak valid atau kosong.']);
        }

        DB::transaction(function () use ($cartItems, $validated, $request) {
            // Hitung total harga barang
            $totalBarang = array_sum(array_column($cartItems, 'total'));
            $ongkosKirim = $totalBarang * 0.1; // Hitung ongkos kirim (10% dari total barang)
            $kembalian = $validated['total_bayar'] - ($totalBarang + $ongkosKirim);

            if ($kembalian < 0) {
                throw new \Exception('Jumlah pembayaran tidak cukup untuk menyelesaikan transaksi.');
            }

            // Handle upload file bukti bayar
            $buktiBayarFilename = null;
            if ($request->hasFile('gambar_bukti_bayar')) {
                $file = $request->file('gambar_bukti_bayar');
                $buktiBayarFilename = $file->getClientOriginalName(); // Ambil nama asli file
                $file->storeAs('uploads/transaksi', $buktiBayarFilename, 'public'); // Simpan file ke direktori
            }

            // Buat transaksi utama (header)
            $transaction = Transaction::create([
                'user_id' => $validated['user_id'],
                'total_bayar' => $validated['total_bayar'],
                'total_harga_kirim' => $ongkosKirim,
                'kembalian' => $kembalian,
                'alamat' => $validated['alamat'],
                'catatan_tambahan' => $validated['catatan_tambahan'] ?? null,
                'metode_bayar' => $validated['metode_bayar'],
                'gambar_bukti_bayar' => $buktiBayarFilename, // Simpan nama asli file
                'status_transaksi' => $validated['status_transaksi'],
                'status_pengiriman' => $validated['status_pengiriman'],
                'tgl_transaksi' => $validated['tgl_transaksi'],
            ]);

            // Log aktivitas: Menambahkan transaksi baru
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'tabel_referensi' => 'transactions',
                'id_referensi' => $transaction->id,
                'deskripsi' => 'Menambahkan Transaksi Baru dengan ID: ' . $transaction->id,
                'created_at' => now(),
            ]);

            // Buat detail transaksi dan kurangi stok produk
            foreach ($cartItems as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->stok < $item['qty']) {
                    throw new \Exception('Stok produk tidak mencukupi untuk pesanan: ' . $product->nama);
                }

                // Kurangi stok produk
                $product->stok -= $item['qty'];
                $product->save();



                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'jmlh_pesan' => $item['qty'],
                    'total_harga_produk' => $item['total'],
                ]);
            }
        });

        return redirect()->route('dashboard.transactions.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }


    public function show(Transaction $transaction)
    {
        // Menghitung total_harga_produk dari transaction_details
        $total_harga_produk = $transaction->details->sum('total_harga_produk');

        // Menghitung ongkos kirim (misalnya 10% dari total harga barang)
        $ongkosKirim = $total_harga_produk * 0.1;

        // Total Harga Seluruh adalah penjumlahan dari Total Harga Barang dan Ongkos Kirim
        $total_harga_seluruh = $total_harga_produk + $ongkosKirim;

        // Total Bayar adalah penjumlahan dari Total Harga Seluruh dan ongkos kirim dari transaksi
        $total_bayar = $total_harga_seluruh + $transaction->total_harga_kirim;

        // Log aktivitas: Melihat detail transaksi
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'tabel_referensi' => 'transactions',
            'id_referensi' => $transaction->id,
            'deskripsi' => 'Melihat Detail Transaksi ID: ' . $transaction->id,
            'created_at' => now(),
        ]);

        // Kirimkan data ke view
        return view('dashboard.admin.transaksi.show', compact('transaction', 'total_bayar', 'total_harga_produk', 'ongkosKirim', 'total_harga_seluruh'));
    }



    public function edit(Transaction $transaction)
    {
        // Muat relasi user dan details.product menggunakan eager loading
        $transaction->load(['user', 'details.product']);

        // Ambil semua produk dan pengguna untuk dropdown (jika diperlukan)
        $products = Product::all();
        $users = User::all();

        // Kembalikan view dengan data yang dibutuhkan
        return view('dashboard.admin.transaksi.edit', compact('transaction', 'products', 'users'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status_transaksi' => 'required|in:Sudah Diproses,Belum Diproses',
            'status_pengiriman' => 'required|in:Sudah Dikirim,Belum Dikirim',
        ]);

        // Simpan perubahan status transaksi dan pengiriman
        $transaction->update([
            'status_transaksi' => $validated['status_transaksi'],
            'status_pengiriman' => $validated['status_pengiriman'],
        ]);

        // Log aktivitas: Mengupdate transaksi
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'tabel_referensi' => 'transactions',
            'id_referensi' => $transaction->id,
            'deskripsi' => 'Mengupdate Transaksi ID: ' . $transaction->id . ' - Status Transaksi: ' . $validated['status_transaksi'] . ', Status Pengiriman: ' . $validated['status_pengiriman'],
            'created_at' => now(),
        ]);

        return redirect()->route('dashboard.transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }



    public function destroy(Transaction $transaction)
    {
        if ($transaction->gambar_bukti_bayar) {
            Storage::delete('public/' . $transaction->gambar_bukti_bayar);
        }

        $transaction->delete();
        return redirect()->route('dashboard.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function print(Transaction $transaction)
    {
        // Memuat data transaksi beserta relasi
        $transaction->load(['details.product', 'user']);

        // Menghitung total_harga_produk dari transaction_details
        $total_harga_produk = $transaction->details->sum('total_harga_produk');

        // Menghitung ongkos kirim (misalnya 10% dari total harga barang)
        $ongkosKirim = $total_harga_produk * 0.1;

        // Total Harga Seluruh adalah penjumlahan dari Total Harga Barang dan Ongkos Kirim
        $total_harga_seluruh = $total_harga_produk + $ongkosKirim;

        // Total Bayar adalah penjumlahan dari Total Harga Seluruh dan ongkos kirim dari transaksi
        $total_bayar = $total_harga_seluruh + $transaction->total_harga_kirim;

        // Memuat view dan langsung stream PDF dengan orientasi portrait
        $pdf = Pdf::loadView('dashboard.admin.transaksi.print', compact(
            'transaction',
            'total_bayar',
            'total_harga_produk',
            'ongkosKirim',
            'total_harga_seluruh'
        ))
            ->setPaper('a4', 'portrait'); // Set paper size to A4 and orientation to portrait

        // Mengembalikan file PDF ke browser untuk ditampilkan
        return $pdf->stream('transaksi-' . $transaction->id . '.pdf');
    }
}
