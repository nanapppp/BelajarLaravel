<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\category;

class insertCategory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        category::create([
            'category_name' => 'Makanan'
        ]);

        category::create([
            'category_name' => 'Minuman'
        ]);

        category::create([
            'category_name' => 'Snack'
        ]);
    }
}
