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
            'account_id' => $this->faker->randomNumber(),
            'balance' => $this->faker->randomNumber(),
            'currency' => $this->faker->word(),
            'user_id' => $this->faker->randomNumber()
        ];
    }
}
