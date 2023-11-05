<?php

namespace Database\Factories\refactoring;

use App\Models\Refactoring\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->numberBetween(1000, 9999),
            'customer' => $this->faker->name,
            'total_amount' => $this->faker->numberBetween(1000, 9999),
            'paid_installments_amount' => $this->faker->numberBetween(100, 999),
            'discount' => $this->faker->numberBetween(10, 50),
            'basic_bonus' => $this->faker->numberBetween(10, 30),
            'min_bonus_amount' => $this->faker->numberBetween(2, 5),
            'bonus_plus' => $this->faker->numberBetween(35, 50),
        ];
    }
}
