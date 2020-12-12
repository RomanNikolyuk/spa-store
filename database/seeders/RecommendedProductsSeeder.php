<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecommendedProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recommended_products')->insert([
            ['product_id' => 1],
            ['product_id' => 2],
            ['product_id' => 3],
            ['product_id' => 4],
            ['product_id' => 5],
            ['product_id' => 6],
            ['product_id' => 7],
            ['product_id' => 8],
            ['product_id' => 9],
            ['product_id' => 10]
        ]);
    }
}
