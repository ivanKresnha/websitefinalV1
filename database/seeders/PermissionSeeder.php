<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Dashboard Access
            ['name' => 'akses_dashboard'],
            
            // sidebar user 
            ['name' => 'akses_kelola_data_user'],
            
            // User Management
            ['name' => 'akses_kelola_pengguna'],
            ['name' => 'akses_data_pengguna'],
            ['name' => 'akses_data_peran_pengguna'],
            ['name' => 'akses_data_akses_pengguna'],
            
            ['name' => 'akses_kelola_user'],
            ['name' => 'akses_tambah_user'],
            ['name' => 'akses_edit_user'],
            ['name' => 'akses_hapus_user'],
            ['name' => 'akses_tampil_user'],

            // Role Management
            ['name' => 'akses_kelola_role'],
            ['name' => 'akses_tambah_role'],
            ['name' => 'akses_edit_role'],
            ['name' => 'akses_hapus_role'],
            ['name' => 'akses_tampil_role'],
            
            // Permission Management
            ['name' => 'akses_kelola_permission'],
            ['name' => 'akses_tampil_permission'],
            
            // Kelola Data  Access
            ['name' => 'akses_kelola_data'],
            // **KATEGORI PRODUK MANAGEMENT** (Add new permissions)
            ['name' => 'akses_kelola_kategori_produk'],
            ['name' => 'akses_tambah_kategori_produk'],
            ['name' => 'akses_edit_kategori_produk'],
            ['name' => 'akses_hapus_kategori_produk'],
            ['name' => 'akses_tampil_kategori_produk'],
            
            
            // Product Management
            ['name' => 'akses_kelola_produk'],
            ['name' => 'akses_tambah_produk'],
            ['name' => 'akses_edit_produk'],
            ['name' => 'akses_hapus_produk'],
            ['name' => 'akses_tampil_produk'],
            
            
            // Transaction Management
            ['name' => 'akses_kelola_transaksi'],
            ['name' => 'akses_tambah_transaksi'],
            ['name' => 'akses_edit_transaksi'],
            ['name' => 'akses_hapus_transaksi'],
            ['name' => 'akses_tampil_transaksi'],
            ['name' => 'akses_print_transaksi'],

            // Report Management
            ['name' => 'akses_kelola_laporan_transaksi'],
            ['name' => 'akses_tampil_laporan_transaksi'],
            ['name' => 'akses_print_laporan_transaksi'],
            
            // Ulasan Management
            ['name' => 'akses_kelola_ulasan'],
            ['name' => 'akses_tambah_ulasan'],
            ['name' => 'akses_edit_ulasan'],
            ['name' => 'akses_hapus_ulasan'],
            ['name' => 'akses_tampil_ulasan'],
           
            // Activity Log Management
            ['name' => 'akses_log_aktivitas'],
            ['name' => 'akses_tampil_log_aktivitas'],



        ];

        Permission::insert($permissions);
    }
}
