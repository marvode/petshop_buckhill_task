<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_uuid' => Category::inRandomOrder()->first()->uuid,
            'title' => fake()->word,
            'price' => fake()->numberBetween(10, 1000),
            'description' => fake()->paragraphs(3, true),
            'metadata' => json_encode([
                'brand' => Brand::inRandomOrder()->first()->uuid,
                'image' => File::factory()->create()->uuid,
            ]),
        ];
    }
}
