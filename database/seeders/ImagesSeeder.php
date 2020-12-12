<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Image::factory()
            ->times(100)
            ->create();

        DB::table('images')->insert([
            ['title' => '/images/products/product-1.jpg', 'product_id' => 1],
            ['title' => '/images/products/product-2.jpg', 'product_id' => 2],
            ['title' => '/images/products/product-4.jpg', 'product_id' => 3],
            ['title' => '/images/products/product-5.jpg', 'product_id' => 3],
            ['title' => '/images/products/product-6.jpg', 'product_id' => 3],
            ['title' => '/images/products/product-7.jpg', 'product_id' => 3],
            ['title' => '/images/products/product-8.jpg', 'product_id' => 3],
            ['title' => '/images/products/product-3.jpg', 'product_id' => 3],
            ['title' => '/images/products/product-3.jpg', 'product_id' => 3],

        ]);
    }
}
