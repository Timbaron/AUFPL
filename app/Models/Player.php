<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'club_id',
        'position',
        'price',
        'player_id',
    ];

    public function club(){
        return $this->belongsTo(Club::class, 'club_id');
    }
    public function points(){
        return $this->hasMany(PlayerPoint::class, 'player_id','player_id');
    }
}
