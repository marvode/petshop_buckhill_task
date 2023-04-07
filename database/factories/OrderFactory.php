<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $payment = Payment::factory()->create();
        return [
            'order_status_id' => OrderStatus::inRandomOrder()->first()->id,
            'payment_id' => $payment->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'products' => json_encode($this->getProducts()),
            'address' => fake()->address,
            'delivery_fee' => fake()->numberBetween(0, 1000),
            'amount' => fake()->numberBetween(1000, 100000),
            'shipped_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    private function getProducts(): array
    {
        $products = [];
        $count = fake()->numberBetween(1, 5);

        for ($i = 0; $i < $count; $i++) {
            $products[] = [
                'product' => Product::inRandomOrder()->first()->uuid,
                'quantity' => fake()->numberBetween(1, 10),
            ];
        }

        return $products;
    }
}
