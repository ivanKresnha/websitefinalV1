<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ActivityLogController;

use Barryvdh\DomPDF\Facade as Pdf;

use App\Http\Controllers\CustomerLandingPageController;

/*
|--------------------------------------------------------------------------| 
| Web Routes
|--------------------------------------------------------------------------|
*/

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Route untuk Logout
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Route untuk Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Route untuk Landing Page
Route::get('/', [CustomerLandingPageController::class, 'index'])->name('landingpage');

/*
|--------------------------------------------------------------------------|
| Group Routes untuk User yang Sudah Login
|--------------------------------------------------------------------------|
*/

Route::middleware(['auth'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    // Group Routes untuk Kelola User
    Route::middleware('auth')->group(function () {
        // Kelola Data User
        Route::resource('users', UserController::class)->names('dashboard.users');

        // Kelola Data Peran User
        Route::resource('roles', RoleController::class)->names('dashboard.roles');

        // Kelola Data Akses User
        Route::resource('permissions', PermissionController::class)->names('dashboard.permissions');


        /*
    |--------------------------------------------------------------------------|
    | Group Routes untuk Kelola Data Produk
    |--------------------------------------------------------------------------|
    */

        // Kelola Data KategoriProduk
        Route::resource('categories', CategoryController::class)->names('dashboard.categories');
        // Kelola Data Produk
        Route::resource('products', ProductController::class)->names('dashboard.products');

        // Kelola Data Transaksi
        Route::resource('transactions', TransactionController::class)->names('dashboard.transactions');

        // Print transaksi
        Route::get('/transactions/{transaction}/print', [TransactionController::class, 'print'])->name('dashboard.transactions.print');


        // log aktivitas
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('dashboard.activityLogs.index');


        // Kelola Data Reviews
        Route::resource('reviews', ReviewController::class)->names('dashboard.reviews');
        // Tambahkan endpoint API untuk mengembalikan produk berdasarkan transaksi.
        Route::get('/transactions/{id}/products', [ReviewController::class, 'getProducts']);
        Route::get('transactions/{transactionId}/products', [ReviewController::class, 'getProducts']);

        Route::prefix('laporan-transaksi')->name('dashboard.laporan_transaksi.')->group(function () {
            // Route untuk halaman index laporan transaksi
            Route::get('/', [LaporanTransaksiController::class, 'index'])->name('index');

            // Route untuk form cetak laporan
            Route::get('/print-laporan-form', [LaporanTransaksiController::class, 'showPrintForm'])->name('print-laporan-form');

            // Route untuk cetak laporan berdasarkan tanggal
            Route::post('/print-data-laporan-pertanggal', [LaporanTransaksiController::class, 'printByDate'])->name('print-data-laporan-pertanggal');
        });
    });

    /*
    |--------------------------------------------------------------------------|
    | Group Routes untuk Kelola Aktivitas
    |--------------------------------------------------------------------------|
    */
    // Jika Anda ingin menggunakan log aktivitas, Anda bisa aktifkan bagian ini
    // Route::middleware('auth')->group(function () {
    //     Route::resource('activity-logs', ActivityLogController::class)->names('dashboard.activity_logs');
    // });
});
