<?php

namespace Database\Factories;

use App\Models\Club;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $clubs = Club::all()->pluck('id')->toArray();
        return [
            'name' => fake()->name(),
            'price' => fake()->numberBetween(4.0,13.0),
            'club_id' => fake()->randomElement($clubs)
        ];
    }
}

