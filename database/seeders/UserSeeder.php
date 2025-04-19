<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Role administrator
        $adminRole = Role::where('name', 'administrator')->first();

        // Role customer
        $customerRole = Role::where('name', 'customer')->first();

        // Tambahkan user dengan role administrator
        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'umur' => 30,
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'kepoyaa',
            'gambar_profil' => null,
        ]);

        // Tambahkan user dengan role customer
        User::create([
            'role_id' => $customerRole->id,
            'name' => 'Customer 1',
            'email' => 'customer@example.com',
            'password' => Hash::make('customer123'),
            'umur' => 25,
            'jenis_kelamin' => 'Perempuan',
            'alamat' => 'kepoyaa',
            'gambar_profil' => null,
        ]);
    }
}
