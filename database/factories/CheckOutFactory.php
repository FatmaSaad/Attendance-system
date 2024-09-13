<?php

namespace Database\Factories;

use App\Models\CheckIn;
use Illuminate\Database\Eloquent\Factories\Factory;


class CheckOutFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'check_in_id' => CheckIn::factory(),
            'created_at' => fake()->dateTimeThisYear(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
