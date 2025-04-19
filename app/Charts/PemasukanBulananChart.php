<?php
 
 namespace App\Charts;

use App\Models\Transaction;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemasukanBulananChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $tahun = date('Y');  // Mengambil tahun saat ini
        $bulan = 12; // Loop hingga bulan Desember
        $dataTotalTransaksi = [];
        $dataBulan = []; // Array untuk menyimpan nama bulan
    
        $user = Auth::user()->load('role');
        $isAdmin = $user->role->name === 'administrator'; // Cek apakah pengguna adalah admin
    
        // Loop untuk setiap bulan dari Januari hingga Desember
        for ($i = 1; $i <= $bulan; $i++) {
            $query = Transaction::whereYear('created_at', $tahun)
                ->whereMonth('tgl_transaksi', $i);
    
            // Jika pengguna bukan admin, filter transaksi berdasarkan user_id
            if (!$isAdmin) {
                $query->where('user_id', $user->id);
            }
    
            // Hitung transaksi berdasarkan role
            if ($isAdmin) {
                // Untuk admin, jumlahkan total_bayar dan total_harga_kirim
                $totalTransaksi = $query->sum(DB::raw('total_bayar - kembalian'));
            } else {
                // Untuk non-admin, hitung total_bayar - kembalian
                $totalTransaksi = $query->sum(DB::raw('total_bayar - kembalian'));
            }
    
            // Menambahkan nama bulan ke array dataBulan
            $dataBulan[] = date('F', mktime(0, 0, 0, $i, 1)); // Mengubah angka bulan menjadi nama bulan
            $dataTotalTransaksi[] = $totalTransaksi;  // Menambahkan total transaksi per bulan ke array dataTotalTransaksi
        }
    
        // Membuat line chart dengan data yang sudah disiapkan
        return $this->chart->lineChart()
            ->setTitle('Data Transaksi Bulanan')
            ->setSubtitle('Total Transaksi Setiap Bulan')
            ->setColors(['#15CC18']) // Set warna garis menjadi hijau
            ->addData('Transaksi Bulanan', $dataTotalTransaksi)
            ->setHeight(270) // Set tinggi chart
            ->setXAxis($dataBulan); // Set sumbu X dengan nama bulan
    }
}
