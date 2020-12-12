<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'small_desc' => 'Короткий опис',
            'big_desc' => $this->faker->paragraph,
            'category_id' => 1,
            'price' => $this->faker->randomFloat(0, 200, 10000)
        ];
    }
}
