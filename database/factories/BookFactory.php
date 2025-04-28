<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'publication_year' => $this->faker->numberBetween(1900, 2023),
            'category_id' => Category::factory(),
            'status' => $this->faker->randomElement(['available', 'available', 'borrowed']), // 66% available
        ];
    }
}
