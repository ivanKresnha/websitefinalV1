<?php

namespace App\Http\Controllers;


use App\Models\ActivityLog;  // Pastikan model ActivityLog sudah dibuat
use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanTransaksiController extends Controller
{
    // Tampilkan halaman laporan transaksi
    public function index()
    {
        // Memuat data transaksi dengan relasi 'details.product' dan 'user'
        $transactions = Transaction::with(['details.product', 'user'])->get();

        // Mengarahkan ke view index laporan transaksi dengan data transaksi
        return view('dashboard.admin.laporan_transaksi.index', compact('transactions'));
    }

    // Tampilkan form untuk cetak laporan berdasarkan tanggal
    public function showPrintForm()
    {
        // Menampilkan form cetak laporan
        return view('dashboard.admin.laporan_transaksi.print-form');
    }

    // Cetak laporan berdasarkan tanggal 
   public function printByDate(Request $request)
   {
       // Validasi input tanggal
       $request->validate([
           'tgl_awal' => 'required|date',
           'tgl_akhir' => 'required|date|after_or_equal:tgl_awal',
       ]);
   
       // Ambil data transaksi berdasarkan rentang tanggal dengan relasi 'details.product' dan 'user'
       $transactions = Transaction::with(['details.product', 'user'])
           ->whereBetween('tgl_transaksi', [$request->tgl_awal, $request->tgl_akhir])
           ->get();
   
       // Cek jika transaksi ditemukan, jika tidak beri pesan error
       if ($transactions->isEmpty()) {
           return redirect()->back()->with('error', 'Tidak ada transaksi untuk rentang tanggal yang dipilih.');
       }

       // Menyimpan log aktivitas untuk pencetakan laporan berdasarkan tanggal
       ActivityLog::create([
           'user_id' => auth()->id(),
           'tabel_referensi' => 'transactions',
           'id_referensi' => null,
           'deskripsi' => 'Mencetak laporan transaksi untuk rentang tanggal ' . $request->tgl_awal . ' hingga ' . $request->tgl_akhir,
       ]);
   
       // Menyiapkan nama admin untuk ditampilkan di footer
       $adminName = auth()->user()->name;
   
       // Memuat view PDF dan menyiapkan data untuk PDF
       $pdf = Pdf::loadView('dashboard.admin.laporan_transaksi.print-laporan-pertanggal', compact('transactions', 'request', 'adminName'))
           ->setPaper('a4', 'landscape');
   
       // Menghasilkan dan menampilkan PDF
       return $pdf->stream('laporan_transaksi_' . $request->tgl_awal . '_to_' . $request->tgl_akhir . '.pdf');
   }
    
}
