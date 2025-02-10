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

        DB::table('users')->insert([
            'role' => 'owner',
            'name' => 'test店舗代表者',
            'email' => 'owner@sample.com',
            'email_verified_at' => '2024-01-01 12:00:00',
            'password' => bcrypt('password')
        ]);

        DB::table('users')->insert([
            'role' => 'general',
            'name' => 'test一般ユーザー１',
            'email' => 'general1@sample.com',
            'email_verified_at' => '2024-01-01 12:00:00',
            'password' => bcrypt('password')
        ]);

        DB::table('users')->insert([
            'role' => 'general',
            'name' => 'test一般ユーザー２',
            'email' => 'general2@sample.com',
            'email_verified_at' => '2024-01-01 12:00:00',
            'password' => bcrypt('password')
        ]);

        DB::table('users')->insert([
            'role' => 'general',
            'name' => 'test一般ユーザー３',
            'email' => 'general3@sample.com',
            'email_verified_at' => '2024-01-01 12:00:00',
            'password' => bcrypt('password')
        ]);
    }
}
