<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('areas')->insert([
            'name' => '東京都'
        ]);

        DB::table('areas')->insert([
            'name' => '大阪府'
        ]);

        DB::table('areas')->insert([
            'name' => '福岡県'
        ]);
    }
}
