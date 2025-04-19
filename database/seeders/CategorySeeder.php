<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::insert([
            [
                'nama' => 'Sosis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Kentang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Nugget',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
