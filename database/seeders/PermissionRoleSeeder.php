<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('name', 'administrator')->first();
        $customerRole = Role::where('name', 'customer')->first();

        // Berikan semua izin ke administrator
        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            $adminRole->permissions()->attach($permission->id, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Berikan izin terbatas ke customer
        $customerPermissions = Permission::whereIn('name', [
            // sidebar
            'akses_dashboard', // Customer can view products
            'akses_kelola_data', // Customer can view products
            
            // Product Management
            'akses_kelola_produk', // Customer can view products
            'akses_tampil_produk', // Customer can view products

            // Transaction Management
            'akses_kelola_transaksi', // Customer can view their transactions
            'akses_tampil_transaksi', // Customer can view their transactions
            'akses_tambah_transaksi', // Customer can make transactions
            'akses_print_transaksi', // Customer can make transactions
            
            // Ulasan Management
            'akses_kelola_ulasan', // Customer can view their transactions
            'akses_tampil_ulasan', // Customer can view reviews
            'akses_tambah_ulasan', // Customer can add reviews 
        ])->get();

        foreach ($customerPermissions as $permission) {
            $customerRole->permissions()->attach($permission->id, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
