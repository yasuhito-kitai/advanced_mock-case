<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reservations')->insert([
            'user_id' => '4',
            'shop_id' => '2',
            'date' => '2025-02-05',
            'time' => '11:00',
            'number' => '2人',
            'visit_status' => '1',
        ]);

        DB::table('reservations')->insert([
            'user_id' => '3',
            'shop_id' => '2',
            'date' => '2025-02-06',
            'time' => '11:00',
            'number' => '2人',
            'visit_status' => '1',
        ]);

        DB::table('reservations')->insert([
            'user_id' => '5',
            'shop_id' => '2',
            'date' => '2025-02-07',
            'time' => '11:00',
            'number' => '2人',
            'visit_status' => '1',
        ]);

        DB::table('reservations')->insert([
            'user_id' => '3',
            'shop_id' => '15',
            'date' => '2025-02-05',
            'time' => '11:00',
            'number' => '2人',
            'visit_status' => '1',
        ]);

        DB::table('reservations')->insert([
            'user_id' => '5',
            'shop_id' => '15',
            'date' => '2025-02-06',
            'time' => '11:00',
            'number' => '2人',
            'visit_status' => '1',
        ]);

        DB::table('reservations')->insert([
            'user_id' => '4',
            'shop_id' => '15',
            'date' => '2025-02-07',
            'time' => '11:00',
            'number' => '2人',
            'visit_status' => '1',
        ]);
    }
}
