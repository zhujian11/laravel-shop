<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductSku;

class ProductSkuFactory extends Factory
{
    protected $model = ProductSku::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'       => $this->faker->word,
            'description' => $this->faker->sentence,
            'price'       => $this->faker->randomNumber(4),
            'stock'       => $this->faker->randomNumber(5),
        ];
    }
}
