<?php

namespace Database\Factories;

use App\Models\JwtToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<JwtToken>
 */
class JwtTokenFactory extends Factory
{
    protected $model = JwtToken::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'unique_id' => $this->faker->sha256,
            'token_title' => 'Default',
            'expires_at' => $this->faker->dateTimeBetween('+1 day', '+1 week'),
        ];
    }
}
