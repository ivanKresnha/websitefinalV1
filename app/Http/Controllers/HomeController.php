<?php

namespace App\Http\Controllers;

use App\Charts\UlasanRatingChart; // Mengimpor chart
use App\Charts\PemasukanBulananChart; // Mengimpor chart
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\TransactionDetail; // Import TransactionDetail model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Add this line to import DB facade

class HomeController extends Controller
{

    public function index(PemasukanBulananChart $transaksiChart, UlasanRatingChart $ulasanRatingChart)
    {
        $user = Auth::user(); // Ambil data pengguna yang sedang login
        $data = []; // Data yang akan dikirimkan ke view

        // Jika user adalah admin (role_id == 1)
        if ($user->role_id == 1) {
            // Ambil data statistik untuk admin
            $totalUsers = User::where('role_id', 2)->count(); // Total users (customer)
            $totalProducts = Product::count(); // Total products
            $totalCategories = Category::count(); // Total product categories
            $totalReviews = Review::count(); // Total reviews
            $totalTransactions = Transaction::count(); // Total transactions

            // Ambil data chart transaksi bulanan
            $data['transaksiChart'] = $transaksiChart->build();

            // Ambil data chart rating ulasan
            $data['ulasanRatingChart'] = $ulasanRatingChart->build();

            $data = array_merge($data, [
                'user' => $user,
                'totalUsers' => $totalUsers,
                'totalProducts' => $totalProducts,
                'totalCategories' => $totalCategories,
                'totalReviews' => $totalReviews,
                'totalTransactions' => $totalTransactions,
            ]);
        } else {
            // Untuk pengguna selain admin (role_id != 1)
            $totalTransactionsUser = Transaction::where('user_id', $user->id)->count(); // Total transaksi per pengguna

            // Cek apakah pengguna adalah admin
            $isAdmin = $user->role->name === 'administrator';

            // Hitung total pengeluaran berdasarkan role pengguna
            if ($isAdmin) {
                $totalSpendingUser = Transaction::where('user_id', $user->id)
                    ->join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
                    ->sum(DB::raw('total_bayar + total_harga_kirim + total_harga_produk')); // Sum for admin
            } else {
                $totalSpendingUser = Transaction::where('user_id', $user->id)
                    ->sum(DB::raw('total_bayar - kembalian')); // For non-admin users
            }

            // Total ulasan per pengguna
            $totalReviewsUser = Review::where('user_id', $user->id)->count();

            // Ambil data chart transaksi bulanan untuk pengguna
            $data['transaksiChart'] = $transaksiChart->build(); // Hanya menampilkan data untuk pengguna ini

            // Ambil data chart rating ulasan untuk pengguna
            $data['ulasanRatingChart'] = $ulasanRatingChart->build(); // Hanya menampilkan rating ulasan pengguna ini

            $data = array_merge($data, [
                'user' => $user,
                'totalTransactionsUser' => $totalTransactionsUser,
                'totalSpendingUser' => $totalSpendingUser,
                'totalReviewsUser' => $totalReviewsUser,
            ]);
        }

        return view('dashboard.admin.dashboard.index', $data);
    }
}
