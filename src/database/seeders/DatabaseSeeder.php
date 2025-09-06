<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        
        $this->call([
            SeasonsTableSeeder::class,       // まず季節テーブル
            ProductsTableSeeder::class,      // 次に商品テーブル
            ProductSeasonTableSeeder::class, // 最後に中間テーブル
        ]);
    }
    
}
