<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


use App\Models\User;

class insertUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            ['name' => 'Admin',
             'email' => 'admin@gmail.com',
             'password' => Hash::make('admin'),  //Hashing password
             'role' => 'admin',
            ],
            [
             'name' => 'Admin2',
             'email' => 'admin2@gmail.com',
             'password' => Hash::make('admin'),
             'role' => 'user',
            ],
        ]);
    }
}
