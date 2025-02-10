<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            'reservation_id' => '1',
            'star' => '2',
            'comment' => 'test',
            'image' => Null,
        ]);

        DB::table('reviews')->insert([
            'reservation_id' => '3',
            'star' => '4',
            'comment' => 'test',
            'image' => Null,
        ]);

        DB::table('reviews')->insert([
            'reservation_id' => '4',
            'star' => '2',
            'comment' => 'test',
            'image' => Null,
        ]);

        DB::table('reviews')->insert([
            'reservation_id' => '5',
            'star' => '1',
            'comment' => 'test',
            'image' => Null,
        ]);

        DB::table('reviews')->insert([
            'reservation_id' => '6',
            'star' => '2',
            'comment' => 'test',
            'image' => Null,
        ]);
    }
}
