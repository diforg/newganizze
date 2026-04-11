<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Recurrence;
use App\Models\Transfer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(Entry::STATUSES);

        return [
            'description' => fake()->sentence(4),
            'nature' => fake()->randomElement(Entry::NATURES),
            'amount' => fake()->randomFloat(2, 0.01, 1000000),
            'competence_date' => fake()->date(),
            'payment_date' => $status === 'paid' ? fake()->date() : null,
            'account_id' => Account::factory(),
            'category_id' => Category::factory(),
            'notes' => fake()->optional(0.6)->paragraph(),
            'attachment_url' => fake()->optional(0.4)->url(),
            'status' => $status,
            'transfer_id' => null,
            'recurrence_id' => null,
        ];
    }

    public function income(): static
    {
        return $this->state(fn (array $attributes) => [
            'nature' => 'income',
            'category_id' => Category::factory()->income(),
        ]);
    }

    public function expense(): static
    {
        return $this->state(fn (array $attributes) => [
            'nature' => 'expense',
            'category_id' => Category::factory()->expense(),
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'payment_date' => fake()->date(),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'payment_date' => null,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'payment_date' => null,
        ]);
    }

    public function withRecurrence(): static
    {
        return $this->state(fn (array $attributes) => [
            'recurrence_id' => Recurrence::factory(),
        ]);
    }

    public function withTransfer(): static
    {
        return $this->state(fn (array $attributes) => [
            'transfer_id' => Transfer::factory(),
        ]);
    }
}
