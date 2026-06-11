<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\product;

class insertProduct extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         product::create([
            'name' => 'Makanan',
             'price' => 9000000,
             'stock' => 100000,
             'description' => 'gtw',
             'category_id' => 1

         ]);
             product::create([
             'name' => 'minuman',
             'price' => 99999999,
             'stock' => 1,
             'description' => 'apa ya',  
             'category_id' => 1
        ]);
    }
}
