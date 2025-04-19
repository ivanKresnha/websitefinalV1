<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Menjalankan RoleSeeder
        $this->call(RoleSeeder::class);
        $this->command->info('RoleSeeder dijalankan.');

        
        // Menjalankan PermissionSeeder
        $this->call(PermissionSeeder::class);
        $this->command->info('PermissionSeeder dijalankan.');
        
        // Menjalankan RolePermissionSeeder
        $this->call(PermissionRoleSeeder::class);
        $this->command->info('PermissionRoleSeeder dijalankan.');
        
        // Menjalankan UserSeeder
        $this->call(UserSeeder::class);
        $this->command->info('UserSeeder dijalankan.');
        // Menjalankan CategorySeeder
        $this->call(CategorySeeder::class);
        $this->command->info('CategorySeeder dijalankan.');
        
        // Menjalankan ProductSeeder
        $this->call(ProductSeeder::class);
        $this->command->info('ProductSeeder dijalankan.');
    }
}
