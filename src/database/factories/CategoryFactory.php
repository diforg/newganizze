<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'nature' => fake()->randomElement(Category::NATURES),
            'icon' => fake()->randomElement(['shopping-bag', 'home', 'briefcase', 'heart', 'car']),
            'color' => fake()->hexColor(),
            'parent_category_id' => fake()->optional(0.35)->passthrough(
                Category::query()->inRandomOrder()->value('id')
            ),
            'archived' => fake()->boolean(10),
        ];
    }

    public function income(): static
    {
        return $this->state(fn (array $attributes) => [
            'nature' => 'income',
        ]);
    }

    public function expense(): static
    {
        return $this->state(fn (array $attributes) => [
            'nature' => 'expense',
        ]);
    }

    public function both(): static
    {
        return $this->state(fn (array $attributes) => [
            'nature' => 'both',
        ]);
    }

    public function withParent(Category $parent): static
    {
        return $this->state(fn (array $attributes) => [
            'parent_category_id' => $parent->id,
        ]);
    }
}