<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'role' => 'admin',
            'name' => '管理者',
            'email' => 'admin@sample.com',
            'email_verified_at' => '2024-01-01 12:00:00',
            'password' => bcrypt('password')
        ]);
    }
}
