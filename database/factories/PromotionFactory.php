<?php

namespace Database\Factories;

use App\Models\File;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promotion>
 */
class PromotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $validFrom = fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d');

        return [
            'title' => fake()->word,
            'content' => fake()->paragraph,
            'metadata' => json_encode([
                'valid_from' => $validFrom,
                'valid_to' => Carbon::parse($validFrom)->addDays(rand(2, 9))->toDate()->format('Y-m-d'),
                'image' => File::factory()->create()->uuid,
            ])
        ];
    }
}
