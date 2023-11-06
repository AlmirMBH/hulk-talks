<?php

namespace Database\Factories\refactoring;

use App\Models\Refactoring\AccountBalance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AccountBalance>
 */
class AccountBalanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => $this->faker->unique()->numberBetween(1, 1000),
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            'currency' => $this->faker->currencyCode(),
            'user_id' => $this->faker->unique()->numberBetween(1, 1000),
        ];
    }

}
