<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalPoints extends Model
{
    use HasFactory;

    // mass assignment
    protected $fillable = [
        'user_id',
        'gameweek',
        'points',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
