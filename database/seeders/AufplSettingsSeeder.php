<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AufplSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AufplSettings::create([
            'current_gameweek' => 1,
            'transfer_window_open' => false,
            'squad_selection_open' => false,
        ]);
    }
}
