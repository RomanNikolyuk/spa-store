<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sliders')->insert([
            ['small_text_1' => 'Будь який текст, він буде забарвлений у елегантний червоний',
            'big_text' => 'Заголовок 1',
            'small_text_2' => 'Опис будь чого, наприклад товару',
            'button_text' => 'Перейти',
            'url' => 'catalog/'],

            ['small_text_1' => 'Будь який текст, він буде забарвлений у елегантний червоний',
            'big_text' => 'Заголовок 2',
            'small_text_2' => 'Опис будь чого, наприклад товару',
            'button_text' => 'Перейти',
            'url' => 'catalog/'],

            ['small_text_1' => 'Будь який текст, він буде забарвлений у елегантний червоний',
            'big_text' => 'Заголовок 3',
            'small_text_2' => 'Опис будь чого, наприклад товару',
            'button_text' => 'Перейти',
            'url' => 'catalog/']
        ]);
    }
}
