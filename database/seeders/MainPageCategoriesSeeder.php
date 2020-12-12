<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainPageCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mainpage_categories')->insert([
            ['category_id' => 1],
            ['category_id' => 2],
            ['category_id' => 3],
            ['category_id' => 4]
        ]);
    }
}
