<?php

namespace Database\Factories;

use App\Models\ProductModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL', 'XXXL']),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomNumber(2, false).$this->faker->numerify('#000')
        ];
    }
}
