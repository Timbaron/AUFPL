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
        $positions = ['GK','DF','MF','FW'];
        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->name(),
            'player_id' => uniqid('AUFPL-'),
            'price' => $faker->numberBetween(4.0,7.0),
            'club_id' => $faker->randomElement($clubs),
            'position' => $faker->randomElement($positions)
        ];
    }
}

