<?php

namespace Database\Factories\refactoring;

use App\Models\Refactoring\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'template' => $this->faker->randomHtml(),
            'description' => $this->faker->name,
            'image' => $this->faker->name,
            'link' => $this->faker->name,
            'status' => $this->faker->numberBetween(0, 1),
            'order' => $this->faker->numberBetween(0, 1),
        ];
    }
}
