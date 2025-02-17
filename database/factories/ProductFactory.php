<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->text(255),
            'description'=>$this->faker->text(255),
            'content'=>$this->faker->paragraph(5),
            'price'=>$this->faker->randomFloat(2, 1000, 50000),
            'price_sale'=>$this->faker->randomFloat(2, 500, 40000),
            'img'=>$this->faker->imageUrl(640, 480, 'products' ),
            'category_id'=>$this->faker->numberBetween(1, 10),
            'slug'=>$this->faker->sentence(3),
            'views'=>$this->faker->numberBetween(0, 10000),
        ];
    }
}
