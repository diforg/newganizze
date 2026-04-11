<?php

namespace Database\Factories;

use App\Models\Recurrence;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recurrence>
 */
class RecurrenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 year', 'now');
        $endDate = fake()->optional(0.7)->dateTimeBetween($startDate, '+2 years');
        $totalInstallments = fake()->optional(0.6)->numberBetween(1, 60);

        return [
            'description' => fake()->sentence(4),
            'frequency' => fake()->randomElement(Recurrence::FREQUENCIES),
            'interval' => fake()->numberBetween(1, 12),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate?->format('Y-m-d'),
            'total_installments' => $totalInstallments,
            'current_installment' => $totalInstallments === null
                ? null
                : fake()->numberBetween(1, $totalInstallments),
        ];
    }

    public function daily(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'daily',
        ]);
    }

    public function weekly(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'weekly',
        ]);
    }

    public function biweekly(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'biweekly',
        ]);
    }

    public function monthly(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'monthly',
        ]);
    }

    public function bimonthly(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'bimonthly',
        ]);
    }

    public function quarterly(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'quarterly',
        ]);
    }

    public function semiannual(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'semiannual',
        ]);
    }

    public function yearly(): static
    {
        return $this->state(fn (array $attributes) => [
            'frequency' => 'yearly',
        ]);
    }

    public function indeterminate(): static
    {
        return $this->state(fn (array $attributes) => [
            'end_date' => null,
            'total_installments' => null,
            'current_installment' => null,
        ]);
    }
}