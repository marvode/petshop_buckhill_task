<?php

namespace Database\Factories;

use App\Enums\PaymentTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(PaymentTypeEnum::cases());
        $details =
            [
                "swift" => fake()->swiftBicNumber(),
                "iban" => fake()->iban,
                "name" => fake()->name,
            ];

        if ($type->is(PaymentTypeEnum::CREDIT_CARD->value)) {
            $details = [
                "holder_name" => fake()->name,
                "number" => fake()->creditCardNumber,
                "ccv" => fake()->numberBetween(100, 999),
                "expire_date" => fake()->creditCardExpirationDate,
            ];
        } else if ($type->is(PaymentTypeEnum::CASH_ON_DELIVERY->value)) {
            $details = [
                "first_name" => fake()->firstName,
                "last_name" => fake()->lastName,
                "address" => fake()->address,
            ];
        }

        return [
            'type' => $type->value,
            'details' => json_encode($details),
        ];
    }
}
