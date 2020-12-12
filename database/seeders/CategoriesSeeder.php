<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['title' => 'Вироби з дерева', 'parent_id' => 0, 'alias' => 'Virobu_z_dereva'],
            ['title' => 'Вироби з металу', 'parent_id' => 0, 'alias' => 'Virobu_z_metalu'],
            ['title' => 'Мінікатегорія 1', 'parent_id' => 1, 'alias' => 'Minicategory_1'],
            ['title' => 'Мінікатегорія 2', 'parent_id' => 2, 'alias' => 'Minicategory_2'],
        ]);
    }
}
