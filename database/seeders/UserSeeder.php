<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1, // Sesuai dengan ID role 'Admin'
            ],
            [
                'name' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'role_id' => 2, // Sesuai dengan ID role 'User'
            ],
        ]);
    }
}
