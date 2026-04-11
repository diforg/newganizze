<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Entry;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $originAccount = Account::factory();
        $destinationAccount = Account::factory();

        return [
            'origin_entry_id' => Entry::factory()->for($originAccount, 'account'),
            'destination_entry_id' => Entry::factory()->for($destinationAccount, 'account'),
            'conversion_rate' => '1.000000',
            'notes' => fake()->optional(0.5)->sentence(),
        ];
    }

    public function withConversion(): static
    {
        return $this->state(fn (array $attributes) => [
            'conversion_rate' => fake()->randomElement(['0.950000', '1.050000', '1.250000', '2.000000']),
        ]);
    }
}
