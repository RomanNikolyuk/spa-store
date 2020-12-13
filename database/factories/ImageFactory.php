<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $imagesPath = [
            '/images/products/product-1.jpg',
            '/images/products/product-2.jpg',
            '/images/products/product-3.jpg',
            '/images/products/product-4.jpg',
            '/images/products/product-5.jpg',
            '/images/products/product-6.jpg',
            '/images/products/product-7.jpg',
            '/images/products/product-8.jpg',
        ];

        return [
            'title' => $this->faker->randomElement($imagesPath),
            'product_id' => $this->faker->randomNumber(2),
        ];
    }
}
