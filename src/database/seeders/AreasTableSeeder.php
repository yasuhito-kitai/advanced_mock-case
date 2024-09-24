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
            'name' => '北海道'
        ]);
        
        DB::table('areas')->insert([
            'name' => '青森県'
        ]);

        DB::table('areas')->insert([
            'name' => '岩手県'
        ]);

        DB::table('areas')->insert([
            'name' => '宮城県'
        ]);

        DB::table('areas')->insert([
            'name' => '秋田県'
        ]);

        DB::table('areas')->insert([
            'name' => '山形県'
        ]);

        DB::table('areas')->insert([
            'name' => '福島県'
        ]);

        DB::table('areas')->insert([
            'name' => '茨城県'
        ]);

        DB::table('areas')->insert([
            'name' => '栃木県'
        ]);
        
        DB::table('areas')->insert([
            'name' => '群馬県'
        ]);

        DB::table('areas')->insert([
            'name' => '埼玉県'
        ]);

        DB::table('areas')->insert([
            'name' => '千葉県'
        ]);

        DB::table('areas')->insert([
            'name' => '東京都'
        ]);

        DB::table('areas')->insert([
            'name' => '神奈川県'
        ]);

        DB::table('areas')->insert([
            'name' => '新潟県'
        ]);

        DB::table('areas')->insert([
            'name' => '富山県'
        ]);

        DB::table('areas')->insert([
            'name' => '石川県'
        ]);

        DB::table('areas')->insert([
            'name' => '福井県'
        ]);

        DB::table('areas')->insert([
            'name' => '山梨県'
        ]);

        DB::table('areas')->insert([
            'name' => '長野県'
        ]);

        DB::table('areas')->insert([
            'name' => '岐阜県'
        ]);

        DB::table('areas')->insert([
            'name' => '静岡県'
        ]);

        DB::table('areas')->insert([
            'name' => '愛知県'
        ]);

        DB::table('areas')->insert([
            'name' => '三重県'
        ]);

        DB::table('areas')->insert([
            'name' => '滋賀県'
        ]);

        DB::table('areas')->insert([
            'name' => '京都府'
        ]);

        DB::table('areas')->insert([
            'name' => '大阪府'
        ]);

        DB::table('areas')->insert([
            'name' => '兵庫県'
        ]);

        DB::table('areas')->insert([
            'name' => '奈良県'
        ]);

        DB::table('areas')->insert([
            'name' => '和歌山県'
        ]);

        DB::table('areas')->insert([
            'name' => '鳥取県'
        ]);

        DB::table('areas')->insert([
            'name' => '岡山県'
        ]);

        DB::table('areas')->insert([
            'name' => '広島県'
        ]);

        DB::table('areas')->insert([
            'name' => '島根県'
        ]);

        DB::table('areas')->insert([
            'name' => '山口県'
        ]);

        DB::table('areas')->insert([
            'name' => '徳島県'
        ]);

        DB::table('areas')->insert([
            'name' => '香川県'
        ]);

        DB::table('areas')->insert([
            'name' => '高知県'
        ]);

        DB::table('areas')->insert([
            'name' => '愛媛県'
        ]);

        DB::table('areas')->insert([
            'name' => '福岡県'
        ]);

        DB::table('areas')->insert([
            'name' => '佐賀県'
        ]);

        DB::table('areas')->insert([
            'name' => '長崎県'
        ]);

        DB::table('areas')->insert([
            'name' => '大分県'
        ]);

        DB::table('areas')->insert([
            'name' => '熊本県'
        ]);

        DB::table('areas')->insert([
            'name' => '宮崎県'
        ]);

        DB::table('areas')->insert([
            'name' => '鹿児島県'
        ]);

        DB::table('areas')->insert([
            'name' => '沖縄県'
        ]);
    }
}
