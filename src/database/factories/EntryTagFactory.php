<?php

namespace Database\Factories;

use App\Models\Entry;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entry_id' => Entry::factory(),
            'tag_id' => Tag::factory(),
        ];
    }
}
