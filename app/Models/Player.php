<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Player extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'club_id',
        'position',
        'price',
        'player_id',
    ];
    public $keyType = 'string';

    public function club(){
        return $this->belongsTo(Club::class, 'club_id');
    }
    public function points(){
        return $this->hasMany(PlayerPoint::class, 'player_id','player_id');
    }

    public function GWPoints(){
        $current_gameweek = Cache::remember('current_gameweek', 86400, function () {
            return AufplSettings::first()->current_gameweek;
        });
        return $this->hasMany(Points::class, 'player_id','player_id')->where('gameweek', $current_gameweek);
    }
}
