<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categories = [
            'Cloths',
            'Books',
            'Kitchen',
            'Kids',
            'Toys',
            'Motorcycle'
        ];

        return [
            'name' => fake()->randomElement($categories),
        ];
    }
}
