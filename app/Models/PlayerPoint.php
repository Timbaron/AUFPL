<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerPoint extends Model
{
    use HasFactory;

    protected $fillable =  [
        'player_id',
        'gameweek',
        'minutes',
        'yellow_card',
        'red_card',
        'motm',
        'goal',
        'assist',
        'cleansheet',
        'own_goal',
        'penalty_missed',
        'penalty_saved',
        'saves',
        'goals_conceded',
    ];
}
