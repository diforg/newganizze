<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'type' => fake()->randomElement(Account::TYPES),
            'icon' => fake()->randomElement(['wallet', 'bank', 'piggy-bank', 'credit-card', 'trending-up']),
            'initial_balance' => fake()->randomFloat(2, -1000, 100000),
            'currency' => fake()->currencyCode(),
            'archived' => fake()->boolean(10),
        ];
    }

    public function checking(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'checking',
        ]);
    }

    public function savings(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'savings',
        ]);
    }

    public function wallet(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'wallet',
        ]);
    }

    public function creditCard(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'credit_card',
        ]);
    }

    public function investment(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'investment',
        ]);
    }
}